<?php

declare(strict_types=1);

/**
 * Seed a representative, editable Akshar Manav homepage in a local Joomla site.
 *
 * This script is intentionally local-only. It updates Joomla modules through the
 * database used by the running container and can be run repeatedly without
 * creating duplicates.
 */

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "This script must be run from the command line.\n");
    exit(1);
}

$configurationPath = '/var/www/html/configuration.php';

if (!is_file($configurationPath)) {
    fwrite(STDERR, "Joomla configuration was not found. Start the local stack and complete Joomla setup first.\n");
    exit(1);
}

require_once $configurationPath;

if (!class_exists('JConfig')) {
    fwrite(STDERR, "Unable to load Joomla database configuration.\n");
    exit(1);
}

$config = new JConfig();
$host = (string) $config->host;
$port = 3306;

if (preg_match('/^(.+):(\d+)$/', $host, $matches) === 1) {
    $host = $matches[1];
    $port = (int) $matches[2];
}

$prefix = (string) $config->dbprefix;

if (preg_match('/^[A-Za-z0-9_]+$/', $prefix) !== 1) {
    fwrite(STDERR, "Unsafe Joomla table prefix.\n");
    exit(1);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $database = new mysqli(
        $host,
        (string) $config->user,
        (string) $config->password,
        (string) $config->db,
        $port
    );
    $database->set_charset('utf8mb4');
    $database->begin_transaction();

    $menuResult = $database->query(
        "SELECT id FROM `{$prefix}menu` "
        . "WHERE client_id = 0 AND home = 1 AND published = 1 "
        . "ORDER BY id ASC LIMIT 1"
    );
    $homeMenuId = (int) ($menuResult->fetch_assoc()['id'] ?? 0);

    if ($homeMenuId < 1) {
        throw new RuntimeException('No published Home menu item was found.');
    }

    $menuModuleResult = $database->query(
        "SELECT id FROM `{$prefix}modules` "
        . "WHERE client_id = 0 AND module = 'mod_menu' "
        . "ORDER BY published DESC, id ASC LIMIT 1"
    );
    $menuModuleId = (int) ($menuModuleResult->fetch_assoc()['id'] ?? 0);

    if ($menuModuleId > 0) {
        $statement = $database->prepare(
            "UPDATE `{$prefix}modules` "
            . "SET position = 'primary-menu', published = 0, showtitle = 0 "
            . "WHERE id = ?"
        );
        $statement->bind_param('i', $menuModuleId);
        $statement->execute();
        assignModule($database, $prefix, $menuModuleId, 0);
    }

    $modules = [
        [
            'marker' => 'AM_LOCAL_HOME_V2:navigation',
            'title' => 'Akshar Manav homepage navigation',
            'position' => 'primary-menu',
            'allPages' => true,
            'ordering' => 1,
            'content' => <<<'HTML'
<ul class="am-nav-list">
  <li><a href="#am-identity">ओळख</a></li>
  <li><a href="#am-current-event">संमेलन १७</a></li>
  <li><a href="#am-work">कार्य</a></li>
  <li><a href="#am-thought">विचार</a></li>
  <li><a href="#am-publication">ई-मासिक</a></li>
  <li><a class="am-nav-list__cta" href="#am-participate">सहभाग</a></li>
</ul>
HTML,
        ],
        [
            'marker' => 'AM_LOCAL_HOME_V1:brand',
            'title' => 'Akshar Manav brand',
            'position' => 'brand',
            'allPages' => true,
            'ordering' => 1,
            'content' => <<<'HTML'
<a class="am-wordmark" href="/" aria-label="अक्षर मानव — मुख्य पान">
  <img class="am-wordmark__symbol" src="/templates/tpl_aksharmanav/images/akshar-manav-symbol.svg" alt="" width="52" height="40">
  <span class="am-wordmark__text">
    <span class="am-wordmark__name">अक्षर मानव</span>
    <span class="am-wordmark__line">विचार · चळवळ · संघटना</span>
  </span>
</a>
HTML,
        ],
        [
            'marker' => 'AM_LOCAL_HOME_V1:identity',
            'title' => 'अक्षर मानवची ओळख',
            'position' => 'home-identity',
            'allPages' => false,
            'ordering' => 1,
            'content' => <<<'HTML'
<div class="am-hero" id="am-identity">
  <div class="am-hero__copy" data-am-reveal>
    <p class="am-kicker">अक्षर मानवची ओळख</p>
    <h1>माणूस केंद्रस्थानी.<br>विचार कृतीत.</h1>
    <p class="am-lede">अक्षर मानव ही विचार, चळवळ आणि संघटना आहे—मानवनिर्मित भेदभाव, विषमता, द्वेष आणि दुरावा कमी करत माणूस, समाज आणि निसर्ग यांच्यातील सुसंवादासाठी काम करणारी.</p>
    <p class="am-factline"><strong>१९८१</strong> अनौपचारिक चळवळीची सुरुवात <span aria-hidden="true">/</span> <strong>१९९६</strong> औपचारिक नोंदणी</p>
    <div class="am-actions">
      <a class="am-button" href="#am-current-event">सध्याचा कार्यक्रम</a>
      <a class="am-text-link" href="#am-work">कामाची व्याप्ती</a>
    </div>
  </div>
  <figure class="am-hero__mark" data-am-logo-assembly aria-label="आठ स्वतंत्र रूपं आणि कृतीची ज्योत">
    <img src="/templates/tpl_aksharmanav/images/akshar-manav-symbol.svg" alt="अक्षर मानवचे आठ रंगीत रूपं आणि ज्योत असलेले चिन्ह" width="640" height="498">
    <figcaption>स्वतंत्र ओळखी. सामूहिक दिशा.</figcaption>
  </figure>
</div>
<div class="am-identity-note" data-am-reveal>
  <span>रंग वेगळे राहतात.</span>
  <span>मधली मोकळी जागा सहअस्तित्वाची आहे.</span>
  <span>ज्योत विचारातून कृतीकडे नेते.</span>
</div>
HTML,
        ],
        [
            'marker' => 'AM_LOCAL_HOME_V1:event',
            'title' => 'माणूस संमेलन १७',
            'position' => 'home-featured-event',
            'allPages' => false,
            'ordering' => 1,
            'content' => <<<'HTML'
<article class="am-event" id="am-current-event">
  <figure class="am-event__image" data-am-reveal>
    <img src="/templates/tpl_aksharmanav/images/manus-sammelan-17-sitakhandi.jpg" alt="सीताखांडी वाकद येथील तलाव, टेकड्या, झाडं आणि राहण्यासाठीची छोटी घरं" width="1536" height="1152" loading="lazy">
    <figcaption>सीताखांडी वाकद · संमेलनस्थळ</figcaption>
  </figure>
  <div class="am-event__content" data-am-reveal>
    <p class="am-kicker">|| अक्षर मानव माणूस संमेलन, सतरा ||</p>
    <p class="am-event__date">२१ · २२ · २३ ऑगस्ट २०२६</p>
    <h2>बदलते स्त्री–पुरुष संबंध</h2>
    <p class="am-event__subject">अर्थात आपली बदलती घरं आणि आपला बदलता समाज—काल, आज आणि उद्या</p>
    <p class="am-lede">रम्य टेकड्या, झाडीझाडोरा, दोन नद्यांचा उगम, हिरवाई, तलाव, छोटी घरं, रिमझिम पाऊस, उबीला शेकोटी, गावरान चवीचे जेवण आणि चांगल्या माणसांचा सहवास. तीन दिवस रमायला, बोलायला आणि ऐकायला जरूर या.</p>
    <dl class="am-event__facts">
      <div><dt>ठिकाण</dt><dd>सीताखांडी वाकद, ता. भोकर, जि. नांदेड</dd></div>
      <div><dt>१७–२० ऑगस्ट</dt><dd>₹१,५००</dd></div>
      <div><dt>संमेलनस्थळी</dt><dd>₹२,०००</dd></div>
      <div><dt>समाविष्ट</dt><dd>राहणे, जेवणे आणि नाश्ता</dd></div>
    </dl>
    <div class="am-actions">
      <a class="am-button am-button--light" href="https://wa.me/919552907898?text=%E0%A4%AE%E0%A4%B2%E0%A4%BE%20%E0%A4%AE%E0%A4%BE%E0%A4%A3%E0%A5%82%E0%A4%B8%20%E0%A4%B8%E0%A4%82%E0%A4%AE%E0%A5%87%E0%A4%B2%E0%A4%A8%20%E0%A5%A7%E0%A5%AD%20%E0%A4%B8%E0%A4%BE%E0%A4%A0%E0%A5%80%20%E0%A4%A8%E0%A4%BE%E0%A4%B5%E0%A4%A8%E0%A5%8B%E0%A4%82%E0%A4%A6%E0%A4%A3%E0%A5%80%20%E0%A4%95%E0%A4%B0%E0%A4%BE%E0%A4%AF%E0%A4%9A%E0%A5%80%20%E0%A4%86%E0%A4%B9%E0%A5%87." target="_blank" rel="noopener">WhatsApp वर संदेश</a>
      <a class="am-text-link am-text-link--light" href="https://www.google.com/maps/search/?api=1&amp;query=19.2400012%2C77.5973485" target="_blank" rel="noopener">तात्पुरते Google स्थान</a>
    </div>
    <p class="am-note">नावनोंदणी: ९५५२९०७८९८ · फक्त WhatsApp संदेश; फोन नको. नकाशातील स्थान अंतिम खात्रीपर्यंत तात्पुरते आहे.</p>
  </div>
</article>
HTML,
        ],
        [
            'marker' => 'AM_LOCAL_HOME_V1:work',
            'title' => 'कार्यविभाग आणि कार्यक्षेत्रे',
            'position' => 'home-work-areas',
            'allPages' => false,
            'ordering' => 1,
            'content' => <<<'HTML'
<div id="am-work">
  <p class="am-kicker">कामाची व्याप्ती</p>
  <h2>जगण्याशी जोडलेली कार्यक्षेत्रे</h2>
  <p class="am-lede">अक्षर मानवचे काम अनेक विभाग, कार्यक्षेत्रे, उपक्रम आणि कार्यक्रमांमधून पुढे जाते. संपूर्ण अधिकृत यादी संपादकीय पडताळणीनंतर स्वतंत्र पानावर उपलब्ध होईल.</p>
  <ul class="am-topic-list" aria-label="निवडक कार्यक्षेत्रे" data-am-reveal>
    <li><span>०१</span>शेती</li><li><span>०२</span>शिक्षण</li><li><span>०३</span>आरोग्य</li><li><span>०४</span>पर्यावरण</li>
    <li><span>०५</span>कला</li><li><span>०६</span>साहित्य</li><li><span>०७</span>श्रम</li><li><span>०८</span>विज्ञान</li>
  </ul>
</div>
HTML,
        ],
        [
            'marker' => 'AM_LOCAL_HOME_V1:initiatives',
            'title' => 'उपक्रम',
            'position' => 'home-initiatives',
            'allPages' => false,
            'ordering' => 1,
            'content' => <<<'HTML'
<div id="am-initiatives">
  <p class="am-kicker">निवडक उपक्रम</p>
  <h2>वेगवेगळ्या वाटांनी माणसं जोडणारे कार्यक्रम</h2>
  <div class="am-card-grid" data-am-reveal>
    <article class="am-card"><p class="am-card__type">सातत्यपूर्ण कार्यक्रम</p><h3>अक्षर मानव माणूस संमेलन</h3><p>माणूस म्हणून भेटण्यासाठी आणि संवादासाठी भरवले जाणारे क्रमांकित संमेलन.</p></article>
    <article class="am-card"><p class="am-card__type">वर्ग</p><h3>अक्षर मानव शिवकावणी वर्ग</h3><p>सध्याचे वर्ग, शिक्षक, वेळापत्रक आणि नावनोंदणीची माहिती लवकरच संपादित केली जाईल.</p></article>
    <article class="am-card"><p class="am-card__type">अभिवाचन विभाग</p><h3>अक्षर मानव वाचन अड्डा</h3><p>वाचन, अभिवाचन आणि चर्चेसाठीचा सातत्यपूर्ण उपक्रम.</p></article>
    <article class="am-card"><p class="am-card__type">बाल विभाग</p><h3>अक्षर मानव मस्तीची पाठशाळा</h3><p>मुलांसाठी शिकण्याचा, अनुभवांचा आणि आनंदाचा उपक्रम.</p></article>
  </div>
</div>
HTML,
        ],
        [
            'marker' => 'AM_LOCAL_HOME_V2:thought',
            'title' => 'विचार',
            'position' => 'home-thought',
            'allPages' => false,
            'ordering' => 1,
            'content' => <<<'HTML'
<div class="am-thought" id="am-thought" data-am-reveal>
  <div>
    <p class="am-kicker">विचार</p>
    <blockquote>
      <p>व्यक्तीची स्वतंत्र ओळख मिटवून नव्हे, तर ती जपत एकत्र येण्यातून सामूहिक दिशा तयार होते.</p>
    </blockquote>
  </div>
  <div class="am-thought__aside">
    <p>आठ रूपं एकाच रंगात मिसळत नाहीत. त्यांच्या मधली मोकळी जागा आदर, संवाद आणि सहअस्तित्वाची आहे.</p>
    <p>तळाशी असलेली ज्योत विचाराला कृतीची उब देते.</p>
  </div>
</div>
HTML,
        ],
        [
            'marker' => 'AM_LOCAL_HOME_V1:publication',
            'title' => 'प्रकाशन',
            'position' => 'home-publication',
            'allPages' => false,
            'ordering' => 1,
            'content' => <<<'HTML'
<div class="am-publication" id="am-publication" data-am-reveal>
  <div>
    <p class="am-kicker">दरमहा डिजिटल ई-मासिक</p>
    <h2>अक्षर मानव</h2>
    <p class="am-publication__meta">विचार · अनुभव · काम · संवाद</p>
    <p class="am-lede">अक्षर मानवचे दरमहा प्रकाशित होणारे डिजिटल ई-मासिक. चळवळीतील विचार, अनुभव आणि विविध क्षेत्रांतील काम नव्या अंकातून वाचा.</p>
  </div>
  <div class="am-publication__action">
    <span aria-hidden="true">अंक / ०१</span>
    <a class="am-button" href="https://heyzine.com/flip-book/c741160b0b.html" target="_blank" rel="noopener">सध्याचा अंक वाचा</a>
  </div>
</div>
HTML,
        ],
        [
            'marker' => 'AM_LOCAL_HOME_V1:participate',
            'title' => 'सहभाग',
            'position' => 'home-participate',
            'allPages' => false,
            'ordering' => 1,
            'content' => <<<'HTML'
<div class="am-participate" id="am-participate" data-am-reveal>
  <p class="am-kicker">सहभाग</p>
  <h2>आजीव सभासद व्हा</h2>
  <p class="am-lede">₹५०० आजीव सभासद शुल्कासाठी स्वतंत्र आणि सुरक्षित नोंदणी व्यवस्था विकसित होत आहे. पेमेंट सेवा निवडून तिची चाचणी पूर्ण होईपर्यंत संकेतस्थळावर ऑनलाइन शुल्क स्वीकारले जाणार नाही.</p>
  <p class="am-note">नोंदणी, कार्यक्रम शुल्क आणि वर्ग प्रवेश या स्वतंत्र प्रक्रिया राहतील.</p>
</div>
HTML,
        ],
        [
            'marker' => 'AM_LOCAL_HOME_V1:footer',
            'title' => 'Akshar Manav footer',
            'position' => 'footer-primary',
            'allPages' => true,
            'ordering' => 1,
            'content' => <<<'HTML'
<div class="am-footer-copy">
  <img src="/templates/tpl_aksharmanav/images/akshar-manav-symbol.svg" alt="" width="88" height="68" loading="lazy">
  <div>
    <p class="am-footer-copy__name">अक्षर मानव</p>
    <p>माणूस, समाज आणि निसर्ग यांच्यातील सुसंवादासाठी काम करणारी विचारधारा, चळवळ आणि संघटना.</p>
  </div>
</div>
HTML,
        ],
    ];

    $created = 0;
    $updated = 0;

    foreach ($modules as $module) {
        $wasCreated = upsertCustomModule(
            $database,
            $prefix,
            $homeMenuId,
            $module['marker'],
            $module['title'],
            $module['position'],
            $module['content'],
            $module['ordering'],
            $module['allPages']
        );

        $wasCreated ? $created++ : $updated++;
    }

    $database->commit();
    printf(
        "Homepage bootstrap complete: %d module(s) created, %d updated; local preview navigation refreshed.\n",
        $created,
        $updated
    );
    fwrite(STDOUT, "All seeded wording remains editable in Joomla Site Modules.\n");
} catch (Throwable $error) {
    if (isset($database) && $database instanceof mysqli) {
        $database->rollback();
    }

    fwrite(STDERR, "Homepage bootstrap failed: {$error->getMessage()}\n");
    exit(1);
}

function upsertCustomModule(
    mysqli $database,
    string $prefix,
    int $homeMenuId,
    string $marker,
    string $title,
    string $position,
    string $content,
    int $ordering,
    bool $allPages
): bool {
    $select = $database->prepare(
        "SELECT id FROM `{$prefix}modules` WHERE client_id = 0 AND note = ? LIMIT 1"
    );
    $select->bind_param('s', $marker);
    $select->execute();
    $moduleId = (int) ($select->get_result()->fetch_assoc()['id'] ?? 0);
    $params = json_encode(
        [
            'prepare_content' => '0',
            'backgroundimage' => '',
            'layout' => '_:default',
            'moduleclass_sfx' => '',
            'cache' => '1',
            'cache_time' => '900',
            'cachemode' => 'static',
        ],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
    );
    $created = false;

    if ($moduleId > 0) {
        $update = $database->prepare(
            "UPDATE `{$prefix}modules` SET title = ?, content = ?, ordering = ?, "
            . "position = ?, published = 1, module = 'mod_custom', access = 1, "
            . "showtitle = 0, params = ?, language = '*' WHERE id = ?"
        );
        $update->bind_param('ssissi', $title, $content, $ordering, $position, $params, $moduleId);
        $update->execute();
    } else {
        $insert = $database->prepare(
            "INSERT INTO `{$prefix}modules` "
            . "(asset_id, title, note, content, ordering, position, checked_out, checked_out_time, "
            . "publish_up, publish_down, published, module, access, showtitle, params, client_id, language) "
            . "VALUES (0, ?, ?, ?, ?, ?, 0, NULL, NULL, NULL, 1, 'mod_custom', 1, 0, ?, 0, '*')"
        );
        $insert->bind_param('sssiss', $title, $marker, $content, $ordering, $position, $params);
        $insert->execute();
        $moduleId = (int) $database->insert_id;
        $created = true;
    }

    assignModule($database, $prefix, $moduleId, $allPages ? 0 : $homeMenuId);

    return $created;
}

function assignModule(mysqli $database, string $prefix, int $moduleId, int $menuId): void
{
    $delete = $database->prepare("DELETE FROM `{$prefix}modules_menu` WHERE moduleid = ?");
    $delete->bind_param('i', $moduleId);
    $delete->execute();

    $insert = $database->prepare(
        "INSERT INTO `{$prefix}modules_menu` (moduleid, menuid) VALUES (?, ?)"
    );
    $insert->bind_param('ii', $moduleId, $menuId);
    $insert->execute();
}

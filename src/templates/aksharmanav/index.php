<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.aksharmanav
 *
 * @copyright   Copyright Akshar Manav
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$app       = Factory::getApplication();
$wa        = $this->getWebAssetManager();
$siteName  = htmlspecialchars((string) $app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu      = $app->getMenu()->getActive();
$pageClass = $menu ? (string) $menu->getParams()->get('pageclass_sfx', '') : '';
$width     = (string) $this->params->get('contentWidth', 'wide');

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$wa->usePreset('template.cassiopeia.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'))
    ->useStyle('template.active.language')
    ->useStyle('template.user')
    ->useScript('template.user')
    ->registerAndUseStyle(
        'template.aksharmanav',
        'templates/' . $this->template . '/css/template.css',
        [],
        ['version' => 'auto']
    )
    ->registerAndUseScript(
        'template.aksharmanav',
        'templates/' . $this->template . '/js/template.js',
        [],
        ['defer' => true, 'version' => 'auto']
    );
?>
<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
  <jdoc:include type="metas" />
  <jdoc:include type="styles" />
  <jdoc:include type="scripts" />
</head>
<body class="am-site am-width-<?php echo htmlspecialchars($width, ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlspecialchars($pageClass, ENT_QUOTES, 'UTF-8'); ?>">
  <a class="am-skip-link" href="#am-main"><?php echo Text::_('TPL_AKSHARMANAV_SKIP_TO_CONTENT'); ?></a>

  <header class="am-header" data-am-header>
    <div class="am-shell am-header__inner">
      <div class="am-brand" aria-label="<?php echo $siteName; ?>">
        <?php if ($this->countModules('brand')) : ?>
          <jdoc:include type="modules" name="brand" style="none" />
        <?php else : ?>
          <a class="am-brand__fallback" href="<?php echo $this->baseurl; ?>/"><?php echo $siteName; ?></a>
        <?php endif; ?>
      </div>

      <?php if ($this->countModules('primary-menu')) : ?>
        <button class="am-menu-toggle" type="button" aria-expanded="false" aria-controls="am-primary-navigation" data-am-menu-toggle>
          <span><?php echo Text::_('TPL_AKSHARMANAV_MENU'); ?></span>
        </button>
        <nav id="am-primary-navigation" class="am-primary-navigation" aria-label="<?php echo Text::_('TPL_AKSHARMANAV_PRIMARY_NAVIGATION'); ?>" data-am-menu>
          <jdoc:include type="modules" name="primary-menu" style="none" />
        </nav>
      <?php endif; ?>

      <?php if ($this->countModules('language-switcher')) : ?>
        <div class="am-language-switcher" aria-label="<?php echo Text::_('TPL_AKSHARMANAV_LANGUAGE_SELECTION'); ?>">
          <jdoc:include type="modules" name="language-switcher" style="none" />
        </div>
      <?php endif; ?>
    </div>
  </header>

  <?php if ($this->countModules('breadcrumbs')) : ?>
    <div class="am-shell am-breadcrumbs">
      <jdoc:include type="modules" name="breadcrumbs" style="none" />
    </div>
  <?php endif; ?>

  <jdoc:include type="message" />

  <main id="am-main" tabindex="-1">
    <?php
    $homePositions = [
        'home-identity',
        'home-featured-event',
        'home-work-areas',
        'home-initiatives',
        'home-thought',
        'home-publication',
        'home-participate',
    ];
    ?>
    <?php foreach ($homePositions as $position) : ?>
      <?php if ($this->countModules($position)) : ?>
        <section class="am-home-section am-home-section--<?php echo htmlspecialchars(substr($position, 5), ENT_QUOTES, 'UTF-8'); ?>" data-am-position="<?php echo htmlspecialchars($position, ENT_QUOTES, 'UTF-8'); ?>">
          <div class="am-shell">
            <jdoc:include type="modules" name="<?php echo $position; ?>" style="html5" />
          </div>
        </section>
      <?php endif; ?>
    <?php endforeach; ?>

    <?php if ($this->countModules('before-component')) : ?>
      <div class="am-shell am-before-component">
        <jdoc:include type="modules" name="before-component" style="html5" />
      </div>
    <?php endif; ?>

    <div class="am-shell am-component">
      <jdoc:include type="component" />
    </div>

    <?php if ($this->countModules('after-component')) : ?>
      <div class="am-shell am-after-component">
        <jdoc:include type="modules" name="after-component" style="html5" />
      </div>
    <?php endif; ?>
  </main>

  <footer class="am-footer">
    <div class="am-shell am-footer__grid">
      <?php if ($this->countModules('footer-primary')) : ?>
        <div><jdoc:include type="modules" name="footer-primary" style="html5" /></div>
      <?php endif; ?>
      <?php if ($this->countModules('footer-secondary')) : ?>
        <div><jdoc:include type="modules" name="footer-secondary" style="html5" /></div>
      <?php endif; ?>
    </div>
  </footer>

  <jdoc:include type="modules" name="debug" style="none" />
</body>
</html>

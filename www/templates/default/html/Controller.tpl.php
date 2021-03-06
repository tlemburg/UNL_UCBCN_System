<?php
use UNL\Templates\Templates;

$page = Templates::factory('Fixed', Templates::VERSION_4_1);

if (file_exists(\UNL\UCBCN\Util::getWWWRoot() . '/wdn/templates_4.1')) {
    $page->setLocalIncludePath(\UNL\UCBCN\Util::getWWWRoot());
}

//Document titles
$title = '';
$site_title = 'UNL Events';
if (!$context->getCalendar()) {
    $title .= 'Page Not Found - UNL Events';
} else {
    $title .= 'UNL';
    if ($context->getCalendar()->id != UNL\UCBCN\Frontend\Controller::$default_calendar_id) {
        $title .= ' | '.$context->getCalendar()->name.' ';
    }
    $title .= ' | Events';
    $site_title = $context->getCalendar()->name . ' Events';
}

$page->doctitle = '<title>' . $title . '</title>';
$page->titlegraphic = $site_title;
$page->setParam('class', 'hide-wdn_navigation_wrapper');
$page->pagetitle = '';
$page->affiliation = '';

//css
$page->addStyleSheet($frontend->getURL().'templates/default/html/css/events.css?v='.UNL\UCBCN\Frontend\Controller::$version);

//javascript
$page->head .= '<script>var frontend_url = "'.$frontend->getURL().'";</script>' . PHP_EOL;
$page->addScript($frontend->getURL().'templates/default/html/js/events.min.js?v='.UNL\UCBCN\Frontend\Controller::$version);

//other head
if ($context->getCalendar()) {
    $page->head .= '<link rel="alternate" type="application/rss+xml" title="' . $context->getCalendar()->name . ' Events" href="' . $frontend->getCalendarURL() . '.rss" />' . PHP_EOL;
}

if ($context->getRaw('output') instanceof UNL\UCBCN\Frontend\RoutableInterface) {
    $page->head .= '<link rel = "canonical" href = "' . $context->output->getURL() . '" />' . PHP_EOL;
}

$page->head .= '<link rel="home" href="' . $context->getCalendarURL() . '" />' . PHP_EOL;

//Navigation
$page->breadcrumbs = '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="' . $frontend->getURL() .'">UNL Events</a></li>
    <li>Events</li>
</ul>';
//$page->navlinks = $savvy->render(null, 'Navigation.tpl.php');

//Render output
$savvy->addGlobal('page', $page);
$view_class = str_replace('\\', '_', strtolower($context->options['model']));

if ($context->getCalendar()) {
    $page->maincontentarea = '
            <div class="wdn-band view-' . $view_class . ' band-nav">
                <div class="wdn-inner-wrapper">
                    <div class="wdn-grid-set">
                        <div class="wdn-col-full">
                            <div class="events-nav">
                                <div class="submit-search">
                                    <a id="frontend_login" href="' . UNL\UCBCN\Frontend\Controller::$manager_url . $context->getCalendar()->shortname . '"><span class="eventicon-plus-circled" aria-hidden="true"></span>Manage Events</a>
                                    <form id="event_search" method="get" action="' . $frontend->getCalendarURL() . 'search/" role="search">
                                        <label for="searchinput">Search Events</label>
                                        <div class="wdn-input-group">
                                            <input type="text" name="q" id="searchinput" placeholder="e.g., Monday, tomorrow" value="' . ((isset($context->options['q']))?$context->options['q']:'') . '"/>
                                            <span class="wdn-input-group-btn">
                                                <button><span class="wdn-icon-search" aria-hidden="true"></span><span class="wdn-text-hidden">search</span></button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                <ul id="frontend_view_selector" class="' . $view_class . '">
                                    <li id="todayview"><a href="' . $frontend->getCurrentDayURL() . '">Today</a></li>
                                    <li id="weekview"><a href="' .  $frontend->getCurrentWeekURL() . '">Week</a></li>
                                    <li id="monthview"><a href="' .  $frontend->getCurrentMonthURL() . '">Month</a></li>
                                    <li id="yearview"><a href="' .  $frontend->getCurrentYearURL() . '">Year</a></li>
                                    <li id="upcomingview"><a href="' .  $frontend->getUpcomingURL() . '">Upcoming</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
}

$template = null;
if ($context->output->getRawObject() instanceof Exception) {
    $template = 'Exception.tpl.php';
}
$page->maincontentarea .= ' 
    <div class="wdn-band view-' . $view_class . ' band-results">
        <div class="wdn-inner-wrapper">
            ' . $savvy->render($context->output, $template) . '
        </div>
    </div>';

$page->leftcollinks = $savvy->render($context, 'localfooter.tpl.php');

//echo everything
echo $page;

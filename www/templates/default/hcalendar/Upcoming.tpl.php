<h4 class="upcoming-header">Upcoming Events:</h4>

<?php echo $savvy->render($context, 'EventListing.tpl.php');?>

<p id="feeds">
    <a id="icsformat" title="ics format for upcoming events" href="<?php echo $frontend->getCalendarURL(); ?>upcoming.ics">ics format for upcoming events</a>
    <a id="rssformat" title="rss format for upcoming events" href="<?php echo $frontend->getCalendarURL(); ?>upcoming.rss">rss format for upcoming events</a>
</p>
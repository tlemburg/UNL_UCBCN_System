<div class="section-heading">
    <h1 class="upcoming-heading">
        Upcoming Events
    </h1>
    <div class="links">
        <a href="<?php echo $frontend->getCalendarURL(); ?>upcoming/.ics"><span class="wdn-icon-calendar" aria-hidden="true"></span><span class="wdn-text-hidden">ics format for upcoming events</span></a>
    </div>
</div>

<?php echo $savvy->render($context, 'EventListing.tpl.php');?>

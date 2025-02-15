<div class="event-summary">
    <a class="event-summary__date t-center" href="#">
        <span class="event-summary__month">
            <?php
            $date = new DateTime(get_field('event-date'));
            echo $date->format('M'); ?>
        </span>
        <span class="event-summary__day"><?php echo $date->format('j'); ?></span>
    </a>
    <div class="event-summary__content">
        <h5 class="event-summary__title headline headline--tiny"><a
                href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <p><?php if (has_excerpt()) {
            echo get_the_excerpt();
        } else {
            echo wp_trim_words(get_the_excerpt(), 18);
        } ?> <a href="#" class="nu gray">Learn more</a>
        </p>
    </div>
</div>
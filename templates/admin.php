<div class="wrap">
    <h1>Ultimate Plugin</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
            settings_fields('ultimate_options_group');
            do_settings_sections('ultimate_plugin');
            submit_button();
        ?>
    </form>
</div>
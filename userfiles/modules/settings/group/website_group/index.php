<?php must_have_access();?>

<script>
    $(document).ready(function () {
        $('body .main > main').addClass('page-settings');
    });
</script>

<?php
$show_inner = false;

if (isset($_GET['group']) and $_GET['group']) {
    $group = $_GET['group'];

    if ($group == 'general') {
        $show_inner = 'settings/group/website';
    } elseif ($group == 'updates') {
        $show_inner = 'updates';
    } elseif ($group == 'email') {
        $show_inner = 'settings/group/email';
    } elseif ($group == 'template') {
        $show_inner = 'settings/group/template';
    } elseif ($group == 'advanced') {
        $show_inner = 'settings/group/advanced';
    } elseif ($group == 'files') {
        $show_inner = 'files/admin';
    } elseif ($group == 'login') {
        $show_inner = 'settings/group/users';
    } elseif ($group == 'language') {
        $show_inner = 'settings/group/language';
    } elseif ($group == 'privacy') {
        $show_inner = 'settings/group/privacy';
    }else{
        $show_inner = false;
        $show_inner = $group;
    }
}
?>

<?php if ($show_inner): ?>
    <module type="<?php print $show_inner ?>"/>
    <?php return; ?>
<?php endif ?>

<div class="card my-3">
    <div class="card-header">
        <h5 class="card-title"><i class="mdi mdi-earth text-primary mr-3"></i> <strong><?php _e('Website settings'); ?></strong></h5>
        <div>

        </div>
    </div>

    <div class="row card-body">

        <div class="card-header col-12 col-sm-6 col-lg-4">
            <a href="<?php echo admin_url();?>settings?group=website" class="d-flex my-3 js-website-settings-link">
                <div class="icon-holder"><i class="mdi mdi-cog-outline fs-1 me-2"></i></div>
                <div class="info-holder card-title">
                    <span class="text-outline-primary font-weight-bold"><?php _e('General'); ?></span><br/>
                    <small class="text-muted"><?php _e('Make basic settings for your website'); ?></small>
                </div>
            </a>
        </div>


        <?php if (mw()->ui->disable_marketplace != true): ?>
        <div class="card-header col-12 col-sm-6 col-lg-4">
            <a href="<?php echo admin_url();?>settings?group=updates" class="d-flex my-3 js-website-settings-link">
                <div class="icon-holder"><i class="mdi mdi-flash-outline fs-1 me-2"></i></div>
                <div class="info-holder card-title">
                    <span class="text-outline-primary font-weight-bold"><?php _e('Updates'); ?></span><br/>
                    <small class="text-muted"><?php _e('Check for the latest updates'); ?></small>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <div class="card-header col-12 col-sm-6 col-lg-4">
            <a href="<?php echo admin_url();?>settings?group=email" class="d-flex my-3 js-website-settings-link">
                <div class="icon-holder"><i class="mdi mdi-email-outline fs-1 me-2"></i></div>
                <div class="info-holder card-title">
                    <span class="text-outline-primary font-weight-bold"><?php _e('E-mail'); ?></span><br/>
                    <small class="text-muted"><?php _e('Email settings'); ?></small>
                </div>
            </a>
        </div>

        <div class="card-header col-12 col-sm-6 col-lg-4">
            <a href="<?php echo admin_url();?>settings?group=template" class="d-flex my-3 js-website-settings-link">
                <div class="icon-holder"><i class="mdi mdi-text-box-check-outline fs-1 me-2"></i></div>
                <div class="info-holder card-title">
                    <span class="text-outline-primary font-weight-bold"><?php _e('Template'); ?></span><br/>
                    <small class="text-muted"><?php _e('Change or manage the theme you use'); ?></small>
                </div>
            </a>
        </div>

        <div class="card-header col-12 col-sm-6 col-lg-4">
            <a href="<?php echo admin_url();?>settings?group=advanced" class="d-flex my-3 js-website-settings-link">
                <div class="icon-holder"><i class="mdi mdi-keyboard-outline fs-1 me-2"></i></div>
                <div class="info-holder card-title">
                    <span class="text-outline-primary font-weight-bold"><?php _e('Advanced'); ?></span><br/>
                    <small class="text-muted"><?php _e('Additional settings'); ?></small>
                </div>
            </a>
        </div>

        <div class="card-header col-12 col-sm-6 col-lg-4">
            <a href="<?php echo admin_url();?>settings?group=files" class="d-flex my-3 js-website-settings-link">
                <div class="icon-holder"><i class="mdi mdi-file-cabinet fs-1 me-2"></i></div>
                <div class="info-holder card-title">
                    <span class="text-outline-primary font-weight-bold"><?php _e('Files'); ?></span><br/>
                    <small class="text-muted"><?php _e('File management'); ?></small>
                </div>
            </a>
        </div>

        <div class="card-header col-12 col-sm-6 col-lg-4">
            <a href="<?php echo admin_url();?>settings?group=users" class="d-flex my-3 js-website-settings-link">
                <div class="icon-holder"><i class="mdi mdi-login fs-1 me-2"></i></div>
                <div class="info-holder card-title">
                    <span class="text-outline-primary font-weight-bold"><?php _e('Login & Register'); ?></span><br/>
                    <small class="text-muted"><?php _e('Manage the access control to your website'); ?></small>
                </div>
            </a>
        </div>

        <div class="card-header col-12 col-sm-6 col-lg-4">
            <a href="<?php echo admin_url();?>settings?group=language" class="d-flex my-3 js-website-settings-link">
                <div class="icon-holder"><i class="mdi mdi-translate fs-1 me-2"></i></div>
                <div class="info-holder card-title">
                    <span class="text-outline-primary font-weight-bold"><?php _e('Language'); ?></span><br/>
                    <small class="text-muted"><?php _e('Choice of language and translations'); ?></small>
                </div>
            </a>
        </div>

        <div class="card-header col-12 col-sm-6 col-lg-4">
            <a href="<?php echo admin_url();?>settings?group=privacy" class="d-flex my-3 js-website-settings-link">
                <div class="icon-holder"><i class="mdi mdi-shield-edit-outline fs-1 me-2"></i></div>
                <div class="info-holder card-title">
                    <span class="text-outline-primary font-weight-bold"><?php _e('Privacy Policy'); ?></span><br/>
                    <small class="text-muted"><?php _e('Privacy Policy and GDPR settings'); ?></small>
                </div>
            </a>
        </div>
    </div>
</div>

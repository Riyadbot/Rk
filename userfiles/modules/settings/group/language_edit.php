<?php must_have_access(); ?>

<script type="text/javascript">
    mw.require('forms.js', true);
</script>

<?php
/*
 * $lang = get_option('language', 'website');
if (!$lang) {
    $lang = 'en';
}
set_current_lang($lang);
*/

$lang = mw()->lang_helper->current_lang();
?>

<script type="text/javascript">

    function importTranslation(namespaceMD5) {
        mw.dialog({
            content: '<div id="mw_admin_import_language_modal_content"></div>',
            title: 'Import Language File',
            height: "auto",
            id: 'mw_admin_import_language_modal'
        });
        var params = {};
        params.namespaceMD5 = namespaceMD5;
        mw.load_module('settings/group/language_import', '#mw_admin_import_language_modal_content', null, params);
    }

    function exportTranslation(namespace) {

        mw.dialog({
            content: '<div id="mw_admin_export_language_modal_content"></div>',
            title: 'Export Language File',
            height: "auto",
            id: 'mw_admin_export_language_modal'
        });
        var params = {};
        params.namespace = namespace;
        mw.load_module('settings/group/language_export', '#mw_admin_export_language_modal_content', null, params);
    }

    function send_lang_form_to_microweber() {

        if (!mw.$(".send-your-lang a").hasClass("disabled")) {

            mw.tools.disable(document.querySelector(".send-your-lang a"), "<?php _e('Sending...'); ?>");

            $.ajax({
                type: "POST",
                url: "<?php echo route('admin.language.send_to_us'); ?>",
                success: function (data) {
                    mw.notification.msg('<?php _e('Thank you for your sharing.'); ?>', 1000, false);
                    mw.tools.enable(document.querySelector(".send-your-lang a"));
                }
            });
        }

        return false;
    }
</script>

<script>
    $('body').on('click', '.js-lang-file-position', function () {
        $(this).find('.mdi').toggleClass('mdi-rotate-270');
    });

    $(document).ready(function () {
        $('.lang-edit-form textarea').keypress(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });

        $('.lang-edit-form textarea').on('focusin', function () {
            $(this).parent().parent().find('.lang-key-holder').addClass('border');
        })

        $('.lang-edit-form textarea').on('focusout', function () {
            $(this).parent().parent().find('.lang-key-holder').removeClass('border');
        })
    });
</script>

<style>
    .lang-key-holder {
        background: #f3f3f3;
        max-width: 100%;
        width: 100%;
        padding: 3px 7px;
        min-height: 45px;
        display: flex;
        align-items: center;
        border: 1px solid transparent;
    }

    .lang-key-holder.border {
        border: 1px solid #4592ff !important;
    }

    .lang-edit-form textarea {
        min-height: 45px;
    }

    .lang-edit-form table,
    .lang-edit-form table th,
    .lang-edit-form table td,
    .lang-edit-form table tr {
        border: 0;
    }
</style>


<div class="card mb-5">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-3 mb-xl-0 mb-3">
                <h5 class="font-weight-bold settings-title-inside"><?php _e("Translation"); ?></h5>
                <small class="text-muted"><?php _e('You can translate the selected language from this fields.'); ?></small>
                <br/>
                <br/>
                <?php if (mw()->ui->enable_service_links and mw()->ui->disable_powered_by_link == false): ?>

                <small class="text-muted"><?php _e('Help us improve'); ?></small>
                <a href="https://microweber.org/go/translation_help"  target="_blank" class="btn btn-outline-primary btn-sm"><?php _e('Help with translation'); ?></a>
                <?php endif; ?>



                <!--
                                <small class=""><?php /*_e('Help us improve Microweber'); */?></small>
                                <a href="javascript:;" onclick="send_lang_form_to_microweber()" class="btn btn-outline-primary btn-sm mt-2"><?php /*_e('Send us your translation'); */?></a>
                                -->
            </div>
            <div class="col-xl-9">
                <form id="language-form" class="lang-edit-form">

                    <?php
                    $getNamespaces = \MicroweberPackages\Translation\Models\TranslationKey::getNamespaces();
                    $namespaceGroups = [
                        'Global' => [],
                        'Modules' => [],
                        'Templates' => [],
                    ];
                    if (!empty($getNamespaces)) {
                        foreach ($getNamespaces as $namespace=>$namespaceData) {
                            if ($namespace == 'global') {
                                $namespaceGroups['Global'][] = $namespaceData;
                            }
                            if (strpos($namespace, 'modules-') !== false) {
                                $namespaceGroups['Modules'][] = $namespaceData;
                            }
                            if (strpos($namespace, 'templates-') !== false) {
                                $namespaceGroups['Templates'][] = $namespaceData;
                            }
                        }
                    }
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-home-11" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Global</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-profile-11" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Modules</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-activity-11" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Templates</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-home-11" role="tabpanel">

                                    <?php foreach ($namespaceGroups['Global'] as $translation):?>
                                        <module type="settings/group/language_edit_browse"
                                                class="js-language-edit-browse-module js-language-edit-browse-<?php echo md5($translation['translation_namespace']);?>"
                                                translation_namespace="<?php echo $translation['translation_namespace']; ?>"
                                                translation_namespace_md5="<?php echo md5($translation['translation_namespace']);?>" search="" page="1" />
                                    <?php endforeach; ?>
                                    
                                </div>
                                <div class="tab-pane" id="tabs-profile-11" role="tabpanel">

                                    <?php foreach ($namespaceGroups['Modules'] as $translation):?>
                                        <module type="settings/group/language_edit_browse"
                                                class="js-language-edit-browse-module js-language-edit-browse-<?php echo md5($translation['translation_namespace']);?>"
                                                translation_namespace="<?php echo $translation['translation_namespace']; ?>"
                                                translation_namespace_md5="<?php echo md5($translation['translation_namespace']);?>" search="" page="1" />
                                    <?php endforeach; ?>

                                </div>
                                <div class="tab-pane" id="tabs-activity-11" role="tabpanel">

                                    <?php foreach ($namespaceGroups['Templates'] as $translation):?>
                                        <module type="settings/group/language_edit_browse"
                                                class="js-language-edit-browse-module js-language-edit-browse-<?php echo md5($translation['translation_namespace']);?>"
                                                translation_namespace="<?php echo $translation['translation_namespace']; ?>"
                                                translation_namespace_md5="<?php echo md5($translation['translation_namespace']);?>" search="" page="1" />
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

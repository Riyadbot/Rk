<?php

must_have_access();

if (isset($params['content-id']) and $params['content-id'] != 0) {
    $data = get_content_by_id($params["content-id"]);
}

$available_content_types = false;
$available_content_subtypes = false;
/* FILLING UP EMPTY CONTENT WITH DATA */
if ($data == false or empty($data)) {
    $is_new_content = true;
    include('_empty_content_data.php');
} else {
    $available_content_types = get_content('group_by=content_type');
    $available_content_subtypes = get_content('group_by=subtype');
}

/* END OF FILLING UP EMPTY CONTENT  */
$show_page_settings = false;
if (isset($params['content-type']) and $params['content-type'] == 'page') {
    $show_page_settings = 1;
}

$template_config = mw()->template->get_config();
$data_fields_conf = false;
$data_fields_values = false;


$content_type_for_data_fields = false;
if(isset($params['content_type'])){
    $content_type_for_data_fields = $params['content_type'];
}else if(isset($params['content-type'])){
    $content_type_for_data_fields = $params['content-type'];
} else if(isset($data['content_type'])){
    $content_type_for_data_fields = $data['content_type'];
}

if (!empty($template_config)) {
    if (isset($content_type_for_data_fields) and $content_type_for_data_fields) {
        if (isset($template_config['data-fields-' . $content_type_for_data_fields]) and is_array($template_config['data-fields-' . $content_type_for_data_fields])) {
            $data_fields_conf = $template_config['data-fields-' . $content_type_for_data_fields];
            if (isset($params['content-id'])) {
                $data_fields_values = content_data($params['content-id']);
            }
        }
    }
}

$post_author_id = user_id();
$all_users = true;

if (isset($data['created_by']) and $data['created_by']) {
    $post_author_id = $data['created_by'];
}
?>

    <script type="text/javascript">
        mw.reset_current_page = function (a, callback) {
            mw.tools.confirm("<?php _ejs("Are you sure you want to Reset the content of this page?  All your text will be lost forever!!"); ?>", function () {
                var obj = {id: a}
                $.post(mw.settings.site_url + "api/content/reset_edit", obj, function (data) {
                    mw.notification.success("<?php _ejs('Content was resetted!'); ?>");

                    if (typeof(mw.edit_content) == 'object') {
                        mw.edit_content.load_editor()
                    }

                    typeof callback === 'function' ? callback.call(data) : '';
                });
            });
        }
        mw.copy_current_page = function (a, callback) {
            mw.tools.confirm("<?php _ejs("Are you sure you want to copy this page?"); ?>", function () {
                var obj = {id: a}
                $.post(mw.settings.site_url + "api/content/copy", obj, function (data) {
                    mw.notification.success("<?php _ejs('Content was copied'); ?>");
                    if (data != null) {
                        var r = confirm("<?php _ejs('Go to the new page?'); ?>");
                        if (r == true) {
                            if (self != top) {
                                top.window.location = mw.settings.site_url + "api/content/redirect_to_content?id=" + data;

                            } else {
                               // mw.url.windowHashParam('action', 'editpage:' + data);
                                window.location = "<?php print admin_url() ?>content/"+data+"/edit";
                            }
                            //content/redirect_to_content_id
                        } else {
                        }
                    }
                    typeof callback === 'function' ? callback.call(data) : '';
                });
            });
        }
        // mw.del_current_page = function (a, callback) {
        //
        //     mw.admin.content.delete(a, function () {
        //         window.location.href = window.location.href;
        //     });
        //
        //
        // }

        mw.adm_cont_type_change_holder_event = function (el) {
            mw.tools.confirm("<?php _ejs("Are you sure you want to change the content type"); ?>? <?php _e("Please consider the documentation for more info"); ?>", function () {
                var root = document.querySelector('#<?php print $params['id']; ?>');
                var form = document.querySelector('.mw_admin_edit_content_form');;
                var ctype = $(el).val()
                if (form != undefined && form.querySelector('input[name="content_type"]') != null) {
                    form.querySelector('input[name="content_type"]').value = ctype;
                }
                // Change api post url to content api
                $(form).attr('action', mw.settings.site_url + "api/content/" + form.querySelector('input[name="id"]').value);
                $(form).attr('content-type-is-changed', 1);
            });
        }
        mw.adm_cont_subtype_change_holder_event = function (el) {
            mw.tools.confirm("<?php _ejs("Are you sure you want to change the content subtype"); ?>? <?php _e("Please consider the documentation for more info"); ?>", function () {
                var root = document.querySelector('#<?php print $params['id']; ?>');
                var form = document.querySelector('.mw_admin_edit_content_form');;
                var ctype = $(el).val();
                if (form != undefined && form.querySelector('input[name="subtype"]') != null) {
                    form.querySelector('input[name="subtype"]').value = ctype
                }
            });
        }
        mw.adm_cont_enable_edit_of_created_at = function () {
            $('.mw-admin-edit-post-change-created-at-value').removeAttr('disabled').show();
            $('.mw-admin-edit-post-display-created-at-value').remove();
        }

        mw.adm_cont_enable_edit_of_updated_at = function () {
            $('.mw-admin-edit-post-change-updated-at-value').removeAttr('disabled').show();
            $('.mw-admin-edit-post-display-updated-at-value').remove();
        }

        //$(document).ready(function (){
        //    $(".collapse").each(function(){
        //        var key = 'collapse' + this.id;
        //        var isStored = mw.storage.get(key);
        //
        //        var el = $(this);
        //
        //        el.on('show.bs.collapse', function (){
        //            mw.storage.set(key, true);
        //            $('[data-bs-target="#'+this.id+'"] .collapse-action-label').html('<?php //_ejs('Hide'); ?>//');
        //        })
        //        el.on('hide.bs.collapse', function (){
        //            mw.storage.set(key, false);
        //            $('[data-bs-target="#'+this.id+'"] .collapse-action-label').html('<?php //_ejs('Show'); ?>//');
        //        })
        //
        //        if( isStored ) {
        //            el.collapse( 'show' );
        //        } else {
        //            el.collapse( 'hide' );
        //        }
        //
        //    });
        //})
    </script>

<?php event_trigger('mw.admin.content.edit.advanced_settings', $data); ?>

<?php if (isset($content_type_for_data_fields)  and $content_type_for_data_fields and isset($params['content-id'])): ?>


    <module type="content/views/settings_from_template" content-type="<?php print $content_type_for_data_fields ?>" content-id="<?php print $params['content-id'] ?>"/>
<?php endif; ?>

   <?php
    $showSeoSettings = true;
    $showAdvancedSettings = true;
    if ($data['content_type'] == 'product_variant') {
        $showSeoSettings = false;
        $showAdvancedSettings = false;
    }
    ?>


    <?php if ($showAdvancedSettings): ?>

    <!-- Advanced Settings -->
  <div class="card">
      <div class="card-body">
          <div class="row">
              <div id="advanced-settings">

                  <h1 class="main-pages-title"><?php _e('Advanced settings') ?></h1>
                  <small class="text-muted mb-2 d-block"><?php _e('Use the advanced settings to customize your blog post') ?></small>

                  <div class="row p-0">
                      <div class="col-md-12">
                          <?php
                          $redirected = false;
                          if (isset($data['original_link']) and $data['original_link'] != '') {
                              $redirected = true;
                          } else {
                              $data['original_link'] = '';
                          }
                          ?>

                          <div class="form-group">
                              <label class="form-label font-weight-bold my-2"><?php _e("Redirect to URL"); ?></label>
                              <small class="text-muted d-block mb-2"><?php _e("If set this, the user will be redirected to the new URL when visits the page"); ?></small>
                              <input type="text" name="original_link" class="form-control" placeholder="<?php _e('http://yoursite.com'); ?>" value="<?php print $data['original_link'] ?>"/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="form-label font-weight-bold my-2"><?php _e("Require login"); ?></label>
                              <small class="text-muted d-block mb-2"><?php _e("If set to yes - this page will require login from a registered user in order to be opened"); ?></small>
                              <div class="form-check form-switch pl-0 d-flex">
                                  <input type="checkbox" class="form-check-input" style="cursor:pointer" id="require_login" name="require_login" data-value-checked="1" data-value-unchecked="0" <?php if ('1' == trim($data['require_login'])): ?>checked="1"<?php endif; ?>>
                              </div>
                          </div>
                      </div>
                      <?php if ($all_users) : ?>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label class="form-label font-weight-bold my-2"><?php _e("Author"); ?></label>

                                  <div id="select-post-author"></div>

                                  <script>mw.require('autocomplete.js')</script>
                                  <?php $user = get_user($post_author_id); ?>
                                  <script>
                                      $(document).ready(function () {
                                          var created_by_field = new mw.autoComplete({
                                              element: "#select-post-author",
                                              ajaxConfig: {
                                                  method: 'get',
                                                  url: mw.settings.api_url + 'users/search_authors?kw=${val}',
                                                  cache: true
                                              },
                                              map: {
                                                  value: 'id',
                                                  title: 'display_name',
                                                  image: 'picture'
                                              },
                                              selected: [
                                                  {
                                                      id: <?php print $post_author_id ?>,
                                                      display_name: '<?php print e(user_name($post_author_id)) ?>'
                                                  }
                                              ]
                                          });
                                          $(created_by_field).on("change", function (e, val) {
                                              $("#created_by").val(val[0].id).trigger('change')
                                          })
                                      });
                                  </script>
                                  <input type="hidden" name="created_by" id="created_by" value="<?php print $post_author_id ?>">
                              </div>
                          </div>
                      <?php endif; ?>
                  </div>

                  <!-- More Advanced Settings -->
                  <?php if (isset($data['id']) and $data['id'] > 0): ?>

                      <script>

                          open_edit_related_content_modal = function($content_id) {
                              var modal_id = 'open_edit_related_content_modal__modal';

                              var dialog = mw.top().dialogIframe({
                                  url: route('live_edit.module_settings') + '?type=content/views/related_content_list&live_edit=true&id=open_edit_related_content_modal__opened__module&content_id='+$content_id+'&from_url=<?php print site_url() ?>',
                                  title: 'Edit related content',
                                  id: modal_id,

                                  height: 'auto',
                                  autoHeight: true
                              })
                          }
                      </script>


                      <div class="row p-0 d-flex align-items-center mt-3">
                          <div class="col-md-8">
                              <label class="form-label font-weight-bold my-2"><?php _e('Related Content'); ?>:</label>
                              <small class="text-muted d-block mb-3"><?php _e('You can add related content to your post or product');?></small>
                              <a class="btn btn btn-outline-primary btn-sm" href="javascript:open_edit_related_content_modal('<?php print $data['id'] ?>');"><?php _e("Edit related"); ?></a>
                          </div>
                          <div class="col-md-4 text-center text-md-right">
                          </div>
                      </div>
                      <div class="row p-0 d-flex align-items-center">
                          <div class="col-md-12 text-center text-md-start">
                              <label class="form-label font-weight-bold my-2 mt-3"><?php _e('More options'); ?>:</label>
                              <a class="btn btn-outline-primary btn-sm" href="javascript:mw.copy_current_page('<?php print ($data['id']) ?>');"><?php _e("Duplicate"); ?></a>&nbsp;
                              <a class="btn btn-outline-primary btn-sm" href="javascript:mw.reset_current_page('<?php print ($data['id']) ?>');"><?php _e("Reset Content"); ?></a>

                          </div>
                      </div>

                  <?php endif; ?>



                  <?php if ($data['content_type'] == 'page'): ?>
                      <div class="row  px-0 mt-3">
                          <div class="col-12">
                              <div class="form-group">
                                  <label class="form-label font-weight-bold my-2"><?php _e("Is Home"); ?></label>
                                  <small class="text-muted d-block mb-2"><?php _e("If yes this page will be your Home"); ?></small>
                                  <div class="form-check form-switch pl-0 d-flex">
                                      <input type="checkbox" name="is_home" class="form-check-input" id="is_home" data-value-checked="1" data-value-unchecked="0" <?php if ($data['is_home']): ?>checked="1"<?php endif; ?> />
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="row p-0 ">
                          <div class="col-12">
                              <div class="form-group">
                                  <label class="form-label font-weight-bold my-2"><?php _e("Is Shop"); ?></label>
                                  <small class="text-muted d-block mb-2"><?php _e("If is enabled, this page will accept products to be added to it"); ?></small>
                                  <div class="form-check form-switch pl-0 d-flex">
                                      <input type="checkbox" name="is_shop" class="form-check-input" id="is_shop" data-value-checked="1" data-value-unchecked="0" <?php if ($data['is_shop']): ?>checked="1"<?php endif; ?> />
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php endif; ?>

                  <?php if (isset($data['position'])): ?>
                      <input name="position" type="hidden" value="<?php print ($data['position']) ?>"/>
                  <?php endif; ?>

                  <?php /* PAGES ONLY  */ ?>
                  <?php event_trigger('mw_admin_edit_page_advanced_settings', $data); ?>


                  <?php if (isset($data['id']) and $data['id'] != 0): ?>


                      <div class="row p-0 ">

                          <div class="col-12">

                              <button type="button" class="btn btn-sm btn-link my-2" data-bs-toggle="collapse" data-bs-target="#set-a-specific-publish-date"><?php _e("Set a specific publish date"); ?></button>

                              <div  class="collapse"   id="set-a-specific-publish-date">
                                  <div class="row p-0">
                                      <script>mw.lib.require('bootstrap_datetimepicker');</script>
                                      <script>
                                          $(function () {
                                              $('.mw-admin-edit-post-change-created-at-value').datetimepicker();
                                              $('.mw-admin-edit-post-change-updated-at-value').datetimepicker();
                                          });
                                      </script>


                                      <?php if (isset($data['created_at'])): ?>
                                          <div class="col-md-12">
                                              <div class="mw-admin-edit-post-created-at" onclick="mw.adm_cont_enable_edit_of_created_at()">
                                                  <small>
                                                      <?php _e("Created on"); ?>: <span class="mw-admin-edit-post-display-created-at-value"><?php print date('Y-m-d H:i:s', strtotime($data['created_at'])) ?></span>
                                                      <input class="form-control form-control-sm mw-admin-edit-post-change-created-at-value" style="display:none" type="text" name="created_at" value="<?php print date('Y-m-d H:i:s', strtotime($data['created_at'])) ?>"  >
                                                  </small>
                                              </div>
                                          </div>
                                      <?php endif; ?>

                                      <?php if (isset($data['updated_at'])): ?>
                                          <div class="col-md-12">
                                              <div class="mw-admin-edit-post-updated-at" onclick="mw.adm_cont_enable_edit_of_updated_at()">
                                                  <small>
                                                      <?php _e("Updated on"); ?>: <span class="mw-admin-edit-post-display-updated-at-value"><?php print date('Y-m-d H:i:s', strtotime($data['updated_at'])) ?></span>
                                                      <input class="form-control form-control-sm mw-admin-edit-post-change-updated-at-value" style="display:none" type="text" name="updated_at" value="<?php print date('Y-m-d H:i:s', strtotime($data['updated_at'])) ?>" >
                                                  </small>
                                              </div>
                                          </div>
                                      <?php endif; ?>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php endif; ?>





                  <?php if (is_array($available_content_types) and !empty($available_content_types)): ?>
                      <div class="row mb-3 p-0">
                          <div class="col-12">
                              <div class="mw-ui-field-holder ">
                                  <span class="font-weight-bold"><?php _e("Content type"); ?>: &nbsp;</span>

                                  <button class="btn btn-outline-warning btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#content-type-settings"><?php print($data['content_type']) ?></button>

                                  <div class="collapse" id="content-type-settings">
                                      <div class="alert alert-dismissible alert-warning mt-3">
                                          <h4 class="alert-heading"><?php _e("Warning!"); ?></h4>
                                          <p class="mb-0"><?php _e("Do not change these settings unless you know what you are doing."); ?></p>
                                      </div>

                                      <div class="row">
                                          <div class="col-md-6">
                                              <label class="form-label font-weight-bold my-2">
                                                  <?php _e("Change content type"); ?>
                                                  <small data-bs-toggle="tooltip" data-title="<?php _e("Changing the content type to different than"); ?> '<?php print $data['content_type'] ?>' <?php _e("is advanced action. Please read the documentation and consider not to change the content type"); ?>"></small>
                                              </label>

                                              <select class="form-select dropup" data-dropup-auto="false" data-width="100%" name="change_content_type" onchange="mw.adm_cont_type_change_holder_event(this)">
                                                  <?php foreach ($available_content_types as $item): ?>
                                                      <option value="<?php print $item['content_type']; ?>" <?php if ($item['content_type'] == trim($data['content_type'])): ?>   selected="selected"  <?php endif; ?>><?php print $item['content_type']; ?></option>
                                                  <?php endforeach; ?>
                                              </select>
                                          </div>
                                          <div class="col-md-6">
                                              <label class="form-label font-weight-bold my-2">
                                                  <?php _e("Change content sub type"); ?>
                                                  <small data-bs-toggle="tooltip" data-title="<?php _e("Changing the content type to different than"); ?> '<?php print $data['subtype'] ?>' <?php _e("is advanced action. Please read the documentation and consider not to change the content type"); ?>"></small>
                                              </label>

                                              <select class="form-select dropup" data-dropup-auto="false" data-width="100%" name="change_contentsub_type" onchange="mw.adm_cont_subtype_change_holder_event(this)">
                                                  <?php foreach ($available_content_subtypes as $item): ?>
                                                      <option value="<?php print $item['subtype']; ?>" <?php if ($item['subtype'] == trim($data['subtype'])): ?>   selected="selected"  <?php endif; ?>><?php print $item['subtype']; ?></option>
                                                  <?php endforeach; ?>
                                              </select>
                                          </div>
                                      </div>
                                  </div>

                              </div>

                          </div>
                          <?php if (isset($data['id'])): ?>
                              <div>
                                  <small>
                                      <?php _e("Id"); ?>: <span class="mw-admin-edit-post-display-id-at-value"><?php print ($data['id']) ?></span>

                                  </small>
                              </div>

                          <?php endif; ?>
                      </div>
                  <?php endif; ?>


              </div>

              <?php include (__DIR__.'/content_delete_btns.php')?>

          </div>
      </div>
  </div>

    <?php endif; ?>






<?php $custom = mw()->module_manager->ui('mw.admin.content.edit.advanced_settings.end'); ?>

<?php if (!empty($custom)): ?>
    <div>
        <?php foreach ($custom as $item): ?>
            <?php $title = (isset($item['title'])) ? ($item['title']) : false; ?>
            <?php $class = (isset($item['class'])) ? ($item['class']) : false; ?>
            <?php $html = (isset($item['html'])) ? ($item['html']) : false; ?>
            <?php print $html; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<?php event_trigger('content.views.advanced_settings', $data); ?>


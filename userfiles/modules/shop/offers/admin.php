<?php must_have_access(); ?>

<?php
$from_live_edit = false;
if (isset($params["live_edit"]) and $params["live_edit"]) {
    $from_live_edit = $params["live_edit"];
}
$allOffers = app()->offer_repository->getAll();
?>

<?php if (isset($params['backend'])): ?>
    <module type="admin/modules/info"/>
<?php endif; ?>

<div class="card">
    <div class="card-body mb-3 <?php if ($from_live_edit): ?>card-in-live-edit<?php endif; ?>">
       <div class="row">

           <div class="card-header d-flex align-items-center justify-content-between px-0">

               <module type="admin/modules/info_module_title" for-module="<?php print $params['module'] ?>"/>

               <?php
                if (!empty($allOffers)):
               ?>
               <a href="javascript:;" class="btn btn-primary js-add-new-offer"><?php _e('Add new offer'); ?></a>

               <?php endif; ?>

           </div>

           <script>
               mw.lib.require('jqueryui');
               mw.require("<?php print $config['url_to_module'];?>css/main.css");
           </script>

           <script>
               function editOffer(offer_id = false) {
                   var data = {};
                   var mTitle = (offer_id ? 'Edit offer' : 'Add new offer');
                   data.offer_id = offer_id;
                   editModal = mw.tools.open_module_modal('shop/offers/edit_offer', data, {overlay: true, skin: 'simple', title: mTitle})
               }

               function reload_offer_after_save() {
                   mw.reload_module_parent('#<?php print $params['id'] ?>');
                   mw.reload_module('shop/offers/edit_offers');
                   window.parent.$(window.parent.document).trigger('shop.offers.update');
                   if (typeof(editModal) != 'undefined' && editModal.modal) {
                       editModal.modal.remove();
                   }
               }

               function deleteOffer(offer_id) {
                   var confirmUser = confirm('<?php _e('Are you sure you want to delete this offer?'); ?>');
                   if (confirmUser == true) {
                       $.ajax({
                           url: '<?php print route('api.offer.delete');?>',
                           data: 'offer_id=' + offer_id,
                           type: 'POST',
                           dataType: 'json',
                           success: function (response) {
                               mw.notification.success('Price is deleted')
                               if (typeof(reload_offer_after_save) != 'undefined') {
                                   reload_offer_after_save();
                               }
                               mw.reload_module('#<?php print $params['id'] ?>')
                               mw.reload_module_parent('custom_fields')

                           }
                       });
                   }
               }


               $(document).ready(function () {

                   $(".js-add-new-offer").click(function () {
                       editOffer(false);
                   });
               });
           </script>


           <?php
           if (!empty($allOffers)):
           ?>

            <module type="shop/offers/edit_offers"/>


           <?php else: ?>


               <div class="text-center you-dont-have-any">
                   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 1679.7 1612.5" style="enable-background:new 0 0 1679.7 1612.5;" xml:space="preserve">
<style type="text/css">
    .st0{fill:#E9EFFF;}
    .st1{fill:#8AA5FF;}
    .st2{fill:#FFFFFF;}
    .st3{fill:#A03B33;}
    .st4{fill:#668CFF;}
    .st5{fill-opacity:0.1961;}
    .st6{fill:#223164;}
    .st7{fill:#668BFF;}
    .st8{fill:#EF7C26;}
    .st9{fill:#EA9668;}
</style>
                       <g id="Special_Offer">
                           <path class="st0" d="M434.1,1420.7c-349.2-180.6-490.2-576.3-414-629c84.3-58.2,471.1,277.2,529,228.4   c63.5-53.5-369.5-484.9-287.5-559.5c56-51,260.9,147.7,521.3,105.9c271.4-43.6,323.3-232.1,498.3-291.3   c336.5-113.9,514.6,330.7,314.3,509.8c-96.2,86-220.9,114.5-241.5,218.5c-25.5,128.8,207.8,198.4,191.7,297.9   C1520.1,1458.6,878.9,1650.7,434.1,1420.7z"/>
                           <g>
                               <g>
                                   <path class="st1" d="M207.3,1529.9c0,0-104.3-310,17.6-362.9s25,201.2,74.9,230.6c49.9,29.4-57.3-303.7,29.4-454.4     s236.5-34.4,174.8,102.8c-61.7,137.2-124.8,370.2-64.6,364.6c60.2-5.6,18.7-113.4,79.1-108.7c60.4,4.7-8.6,228.1-8.6,228.1H207.3     z"/>
                                   <g>
                                       <g>
                                           <path class="st2" d="M458.3,1019.9c-1,0-1.9-0.6-2.2-1.6c-0.4-1.2,0.3-2.5,1.5-2.9c23.3-7.1,38.5-25.1,33.9-40.2       c-0.4-1.2,0.3-2.5,1.5-2.9c1.2-0.4,2.5,0.3,2.9,1.5c5.3,17.5-11.3,38.1-37,45.9C458.8,1019.9,458.5,1019.9,458.3,1019.9z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M321.4,1041.2c-1.3,0-2.3-1-2.3-2.3s1-2.3,2.3-2.3c24.9,0,45.1-27.5,45.1-61.3c0-1.3,1-2.3,2.3-2.3       c1.3,0,2.3,1,2.3,2.3C371.1,1011.7,348.8,1041.2,321.4,1041.2z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M461.3,1134.7c-42,0-76.1-29.2-76.1-65.1c0-1.3,1-2.3,2.3-2.3c1.3,0,2.3,1,2.3,2.3       c0,33.4,32.1,60.5,71.5,60.5c1.3,0,2.3,1,2.3,2.3C463.6,1133.7,462.6,1134.7,461.3,1134.7z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M315.9,1253.3c-1.3,0-2.3-1-2.3-2.3s1-2.3,2.3-2.3c19.6,0,36.2-45.9,36.2-100.3c0-1.3,1-2.3,2.3-2.3       c1.3,0,2.3,1,2.3,2.3C356.8,1207.2,338.8,1253.3,315.9,1253.3z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M405.2,1289c-9.9,0-14.4-27-14.4-52c0-1.3,1-2.3,2.3-2.3c1.3,0,2.3,1,2.3,2.3c0,30.7,6.5,47.5,9.8,47.5       c1.3,0,2.3,1,2.3,2.3C407.5,1287.9,406.4,1289,405.2,1289z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M321.4,1422.9c-1.3,0-2.3-1-2.3-2.3c0-1.3,1-2.3,2.3-2.3c16.7,0,30.7-39.1,30.7-85.4c0-1.3,1-2.3,2.3-2.3       c1.3,0,2.3,1,2.3,2.3C356.8,1383.4,341.2,1422.9,321.4,1422.9z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M409.6,1422.9c-19.5,0-35.3-12.7-35.3-28.2c0-1.3,1-2.3,2.3-2.3c1.3,0,2.3,1,2.3,2.3       c0,13.1,13.8,23.7,30.8,23.7c1.3,0,2.3,1,2.3,2.3C411.9,1421.8,410.8,1422.9,409.6,1422.9z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M477.9,1470.4c-1.3,0-2.3-1-2.3-2.3s1-2.3,2.3-2.3c13.3,0,27.5-31.3,27.5-77.9c0-1.3,1-2.3,2.3-2.3       c1.3,0,2.3,1,2.3,2.3C509.9,1434.1,495.8,1470.4,477.9,1470.4z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M445.9,1497.2c-13.3,0-23.8-16.9-23.8-38.4c0-1.3,1-2.3,2.3-2.3c1.3,0,2.3,1,2.3,2.3       c0,18.6,8.6,33.8,19.2,33.8c1.3,0,2.3,1,2.3,2.3C448.2,1496.2,447.2,1497.2,445.9,1497.2z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M205.8,1289c-1.3,0-2.3-1-2.3-2.3c0-1.3,1-2.3,2.3-2.3c9.9,0,20.8-29.9,20.8-72.9c0-1.3,1-2.3,2.3-2.3       s2.3,1,2.3,2.3C231.2,1249,222.3,1289,205.8,1289z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M266.4,1359.7c-14.4,0-22.1-37.6-22.1-73c0-1.3,1-2.3,2.3-2.3c1.3,0,2.3,1,2.3,2.3       c0,40.3,9.2,68.5,17.5,68.5c1.3,0,2.3,1,2.3,2.3S267.6,1359.7,266.4,1359.7z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M193.7,1404.6c-1.3,0-2.3-1-2.3-2.3s1-2.3,2.3-2.3c3.3,0,9.8-19.1,9.8-54.2c0-1.3,1-2.3,2.3-2.3       c1.3,0,2.3,1,2.3,2.3C208.1,1366.2,205.1,1404.6,193.7,1404.6z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M299.4,1479.2c-27.4,0-49.7-32.1-49.7-71.6c0-1.3,1-2.3,2.3-2.3c1.3,0,2.3,1,2.3,2.3       c0,36.9,20.2,67,45.1,67c1.3,0,2.3,1,2.3,2.3C301.7,1478.2,300.7,1479.2,299.4,1479.2z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M330.3,1497.2c-1.3,0-2.3-1-2.3-2.3c0-1.2,1-2.2,2.2-2.3c2-1.1,5.5-12.4,5.5-31.7c0-1.3,1-2.3,2.3-2.3       c1.3,0,2.3,1,2.3,2.3C340.2,1474.4,338.1,1497.2,330.3,1497.2z"/>
                                       </g>
                                       <g>
                                           <path class="st2" d="M431.6,987.1c-28,0-50.8-33.1-50.8-73.9c0-1.3,1-2.3,2.3-2.3s2.3,1,2.3,2.3c0,38.2,20.7,69.3,46.2,69.3       c1.3,0,2.3,1,2.3,2.3S432.9,987.1,431.6,987.1z"/>
                                       </g>
                                   </g>
                               </g>
                               <circle class="st1" cx="492.7" cy="1240.4" r="28.4"/>
                               <circle class="st1" cx="521.1" cy="1151" r="11.7"/>

                               <ellipse transform="matrix(0.7071 -0.7071 0.7071 0.7071 -706.8908 757.2535)" class="st1" cx="560.6" cy="1231.9" rx="8.4" ry="8.4"/>
                               <circle class="st1" cx="268.4" cy="1127.5" r="12.8"/>
                           </g>
                           <g>
                               <g>
                                   <path class="st3" d="M835.3,1451c-2.7,32.8-5.4,65.7-30.2,83.7c-24.8,18-71.7,21.3-94.1,28.9c-22.4,7.6-20.4,19.6-18.3,31.5     l234,1.3c6.3-15.8,12.6-31.7,8.7-45.9c-3.9-14.2-18-26.7-23.6-43.9c-5.7-17.1-2.9-38.9-0.1-60.6L835.3,1451z"/>
                               </g>
                               <g>
                                   <path class="st4" d="M911.6,1446.1l-76.3,4.9l-0.7,8.2c-1,16.7-3.8,32.1-8.4,46.3c-3.3,9.4-8.4,17.5-15.3,24.4     c-4.8,4.4-10.4,8.2-16.8,11.4c8.4,2.9,16.6,5.3,24.4,7.2c5.5,1.1,10.6,1.7,15.3,1.7c5.1,0,9.7-0.7,13.8-2.1     c1.7-0.2,6.4-2.5,14.1-7c20.6-15,32.9-23.2,36.7-24.6c3.4-1.8,8.2-4.1,14.6-6.7c-1.6-3.8-2.4-6.3-2.5-7.5     C907.5,1488.8,907.9,1470,911.6,1446.1L911.6,1446.1z"/>
                               </g>
                               <g>
                                   <path class="st5" d="M911.6,1446.1l-76.3,4.9l-0.7,8.2c-1,16.7-3.8,32.1-8.4,46.3c-2.2,6.4-5.3,12.2-9.2,17.4l93.5-20.7     C907.5,1488.7,907.9,1470,911.6,1446.1L911.6,1446.1z"/>
                               </g>
                               <g>
                                   <path class="st3" d="M1394.6,1410.1c22.6,23.9,45.3,47.9,42.2,78.4s-32,67.6-41.3,89.4s1,28.2,11.2,34.7l157.2-173.3     c-7.6-15.3-15.2-30.5-28.3-37.1c-13.2-6.6-31.9-4.5-48.4-11.7c-16.5-7.2-30.9-23.8-45.2-40.4L1394.6,1410.1z"/>
                               </g>
                               <g>
                                   <path class="st4" d="M1441.9,1350l-47.3,60.1l5.6,6c11.8,11.9,21.4,24.3,28.9,37.2c4.8,8.7,7.4,17.9,7.9,27.7     c0.1,6.5-0.8,13.2-2.8,20.1c7.8-4.3,15-8.8,21.7-13.4c4.5-3.4,8.4-6.8,11.5-10.3c3.4-3.8,6-7.7,7.7-11.7c1-1.4,2.4-6.4,4.2-15.1     c2.6-25.4,4.7-39.9,6.2-43.7c0.9-3.7,2.5-8.8,4.8-15.4c-3.9-1.4-6.3-2.4-7.2-3.2C1470.9,1381.6,1457.2,1368.8,1441.9,1350     L1441.9,1350z"/>
                               </g>
                               <g>
                                   <path class="st5" d="M1441.9,1350l-47.3,60.1l5.6,6c11.8,11.9,21.4,24.3,28.9,37.2c4.4,8,7,16.4,7.7,25.3l42.7-92.3     C1468.4,1379.2,1455.8,1367.1,1441.9,1350z"/>
                               </g>
                               <g>
                                   <path class="st6" d="M1078,650.3C1009.9,777.7,941.7,905,881.2,1044c-60.6,139-113.5,289.6-166.5,440.2l316.5,7     c-50.2-112.8-100.4-225.5-36.4-371.2s242.1-324.2,275-407.9c21.7-55.2-19.7-69.2-82.7-69.2C1154.6,642.8,1116.3,646.6,1078,650.3     z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M864.1,1344.6l-1.3,4.1l-0.9,4.2l-0.6,4.3l-0.3,4.3l0,4.3l0.3,4.3l0.6,4.3l0.9,4.2l1.2,4.1l1.5,4l1.8,3.9     l2.1,3.8l2.4,3.6l2.6,3.4l2.9,3.2l3.1,3l3.3,2.8l3.5,2.6l3.7,2.3l3.9,2l4,1.7l4.1,1.4l4.2,1.1l4.3,0.8l4.3,0.5l4.4,0.1l4.4-0.2     l4.3-0.5l4.3-0.8l4.2-1.1l4.1-1.4l4-1.7L864.1,1344.6z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M844.1,1132.4c-4.3,10.7-8.7,21.9-13.2,33.5l90.7,62c4.4-31.2-5.4-57.1-29.3-77.6l-5-3.7     c-3.4-2.3-7-4.4-10.8-6.2c-7.5-3.6-15.4-6-23.7-7.2C849.8,1132.7,846.9,1132.5,844.1,1132.4L844.1,1132.4z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M963.6,1017.2c1.1,11.3,4.3,22,9.6,32c1.8,3.3,3.7,6.5,5.9,9.5c2.2,3,4.6,5.9,7.1,8.7l4,4     c6.7,6,13.7,10.8,21.3,14.4c3.5-6.6,7.2-13.3,11.1-20L963.6,1017.2L963.6,1017.2z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M736.8,1421.1c-3.5,9.9-7,19.9-10.6,30.1l32.1,34l11.8,0.3l26,0.6c0-1-0.1-2-0.2-3     c-1.3-14.1-6.4-26.7-15.3-37.7c-9-10.8-20.2-18.2-33.6-22.1C743.6,1422.2,740.2,1421.5,736.8,1421.1L736.8,1421.1z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M856.6,1269.1l-69,11c-1.8,5-3.7,10.1-5.6,15.3l0.8,0l6.2-0.2l6.2-0.5l6.2-0.8l6.7-1.3l6.6-1.7l6.5-2     c4.3-1.5,8.5-3.2,12.6-5.2C841.9,1279.6,849.5,1274.8,856.6,1269.1L856.6,1269.1z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M964.6,1258.4c-6.9,4.6-12.4,10.8-16.7,18.6c-2.6,5-4.4,10.3-5.2,15.9c-0.4,2.8-0.6,5.6-0.6,8.4l0.2,4.2     c0.3,2.8,0.8,5.6,1.5,8.3c1.4,5.3,3.6,10.2,6.6,14.8c4,5.5,6.6,8.6,7.8,9.3c2,1.9,4.1,3.5,6.3,5.1c4.3,2.8,8.8,5,13.4,6.5     c-2.8-10.4-5.3-21-7.7-31.5C966.6,1298.6,964.8,1278.8,964.6,1258.4L964.6,1258.4z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M958.6,1446c-4.5,0-9,0.7-13.5,2c-9.2,2.8-16.8,8-22.8,15.4c-5.8,7.4-9.2,15.7-10.1,25.2l31.1,0.7l29.3-41.1     C968,1446.7,963.3,1446,958.6,1446z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M767.5,1335.1c-3.7,10.3-7.5,20.7-11.3,31.4l17.5,28.1c0.8-0.5,2.7-2.8,5.6-6.7c1.1-1.6,2-3.3,2.8-5.1     c1.6-3.6,2.7-7.3,3.1-11.2c0.9-7.9-0.6-15.4-4.4-22.5c-1-1.7-2-3.4-3.3-5l-1.9-2.3c-1.3-1.5-2.8-2.8-4.3-4.1     C770.1,1336.8,768.8,1335.9,767.5,1335.1L767.5,1335.1z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1008.7,780.5C966,862.4,929.1,937.6,898,1006.2c14.1-1,28.1-4.2,41.9-9.4c28.3-11.2,51-29.3,68.1-54.3     c4.1-6.1,7.7-12.4,10.9-19l4.3-10.1c2.6-6.8,4.7-13.8,6.3-21c3.2-14.4,4.1-28.9,2.9-43.6C1030.2,823.7,1022.2,800.9,1008.7,780.5     L1008.7,780.5z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1085,888c-26.1,27.9-39.4,61-39.7,99.3l0.4,9.3l1,9.3l1.6,9.2l1.7,7c11.4-17.4,23.5-34.8,36.2-52.2     L1085,888z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M883.7,1038.2c-0.9,2-1.7,3.9-2.6,5.8c-4.3,9.6-8.7,19.8-13.3,30.6l16.4,22.8c10.4-1.6,18-7,23-16.2     c1.5-2.9,2.4-6,2.9-9.3c0.3-4.1,0.4-6.5,0.1-7.3c-0.2-1.6-0.5-3.2-0.9-4.8c-1.4-4.1-2.4-6.4-3-7.1c-0.9-1.5-1.9-2.9-3-4.2     c-2.2-2.6-4.9-4.8-7.9-6.6c-1.5-0.9-3-1.6-4.7-2.2C887.2,1038.8,884.9,1038.3,883.7,1038.2L883.7,1038.2z"/>
                               </g>
                               <g>
                                   <path class="st6" d="M1145.5,730.2c-27,131-53.9,262.1-19.5,390c34.4,127.9,130.3,252.8,226.1,377.7l174.5-200     c-130.8-64.5-261.6-129-282.9-233.7c-21.3-104.7,66.9-249.7,68.8-312.1c0.9-31.5-20.1-41.9-52.1-41.9     C1229.1,710.2,1187.3,720.2,1145.5,730.2z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1240.7,756.5l-6.6,4.9l-6.2,5.4l-5.8,5.8l-5.3,6.2l-4.9,6.6l-4.4,7l-3.8,7.3l-3.3,7.5l-2.7,7.7l-2.2,7.9     l-1.6,8.1l-1,8.2l-0.4,8.2l0.2,8.2l0.8,8.2l1.4,8.1l2,7.9l2.6,7.8l3.2,7.6l3.7,7.3l4.2,7l4.8,6.7l5.2,6.3l5.7,5.9l6.1,5.5l6.5,5     l6.8,4.5l7.1,4l7.4,3.5l7.7,2.9l7.9,2.3L1240.7,756.5z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1124.4,837.5c-6.6,40.6-11.3,81.1-14,121.4c-1.5,27.5-1,54.9,1.6,82.2c21.6-13.6,37.7-32.2,48.3-55.6     c10.6-24.4,13.3-49.7,8.1-75.7c-5.5-25.7-17.7-47.7-36.7-65.9C1129.4,841.6,1126.9,839.5,1124.4,837.5L1124.4,837.5z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1232.1,1008.1l-4.7,2.2l-4.5,2.5l-4.3,2.9l-4.1,3.2l-3.8,3.5l-3.6,3.7l-3.3,4l-3,4.2l-2.7,4.4l-2.3,4.6     l-2,4.8l-1.6,4.9l-1.3,5l-0.9,5.1l-0.5,5.1l-0.2,5.1l0.2,5.1l0.6,5.1l1,5.1l1.3,5l1.7,4.9l2,4.7l2.4,4.6l2.7,4.4l3,4.2l3.3,3.9     l3.6,3.7l3.9,3.4l4.1,3.1l4.3,2.8L1232.1,1008.1z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1161.4,1161.9c-7.5,0.1-14.6,1.2-21.4,3.5c2.9,7.3,7.1,16.9,12.6,28.8l75.8,43.1     c1.5-13.6-0.8-26.5-6.9-38.7c-0.5-1.6-3.2-5.8-8.2-12.5c-4.3-5.1-9.2-9.5-14.8-13.2C1187.2,1165.7,1174.8,1162,1161.4,1161.9z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1278.7,1136.3c-1.2,1.3-2.3,2.6-3.4,4c-4.3,6.2-6.6,10.1-6.9,11.6c-1.2,2.8-2.2,5.6-2.9,8.6     c-0.7,1.4-1.2,5.9-1.5,13.4c0.1,6.1,1.2,12,3.3,17.7c2.1,5.7,5.1,10.9,8.9,15.5c5,5.4,8.2,8.4,9.6,9c2.4,1.7,4.9,3.3,7.5,4.6     c7.9,3.9,15.9,5.8,24.1,5.8c6.1,0,12.3-1.1,18.6-3.3c5.6-2.1,10.6-4.9,15.2-8.7c4.2-3.9,7-6.6,8.3-8.3     c-5.2-3.4-10.3-6.8-15.4-10.2C1304.7,1164.7,1282.9,1144.8,1278.7,1136.3L1278.7,1136.3z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1239.3,1288.9c-4.2,0-8.4,0.4-12.6,1.2l-4.8,1.1c-3.2,0.9-6.2,2-9.2,3.4c-1.8,0.8-3.5,1.7-5.1,2.6     c5,7.9,10.5,16.3,16.5,25.3l79.2,34.8c0.8-13.4-2.3-25.9-9.2-37.5c-7.1-11.5-16.7-20-29-25.5     C1256.8,1290.7,1248.2,1288.9,1239.3,1288.9z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1312.8,1285.8l3.1,2.2l3.3,2l3.4,1.7l3.5,1.5l3.6,1.2l3.7,1l3.8,0.7l3.8,0.4l3.8,0.2l3.8-0.1l3.8-0.4     l3.8-0.7l3.7-0.9l3.7-1.2l3.6-1.4l3.6-1.8l3.5-2l3.3-2.3l3.1-2.5l2.9-2.8l2.7-3l2.5-3.2l2.2-3.3l2-3.5l1.7-3.6l1.4-3.8l1.2-3.9     l0.9-3.9l0.6-4L1312.8,1285.8z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1349.7,1342.7l-54.8,79.6l16.5,21.9c10.4-6.5,19.2-14.8,26.2-24.9c14.5-21.6,19-45.1,13.6-70.6     L1349.7,1342.7z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1435.8,1322.5l-6.2,0.1c-8.3,0.4-16.4,1.9-24.3,4.6l-5.8,2.2c-3.8,1.6-7.5,3.5-11,5.7l-5.2,3.4l77.4,34.7     l27.1-31.1c-4.9-4-10.3-7.6-16.3-10.7c-7.4-3.7-15.3-6.2-23.5-7.7C1444.1,1323,1440,1322.6,1435.8,1322.5z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1420.8,1407.8c-5.3,0-10.7,0.8-16.2,2.5c-5.3,1.7-10.2,4.3-14.7,7.6c-2.2,1.7-4.3,3.5-6.2,5.5     c-4.5,5.2-7.1,8.5-7.5,9.9c-2.8,4.8-4.8,10-6,15.5c-0.6,2.7-0.9,5.5-1.1,8.3l0,4.2c0.1,2.8,0.4,5.6,1,8.3c0.4,2,0.9,4,1.6,5.9     l58.3-66.8C1426.9,1408.1,1423.9,1407.8,1420.8,1407.8z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1444.9,1256.9c1.2,8.8,4.5,16.6,10,23.7c6.3,7.9,14.2,13.3,23.8,16.4c4.8,1.5,9.6,2.2,14.4,2.2     c4.8,0,9.7-0.7,14.5-2.2l-8.5-12.2C1480.5,1275.7,1462.4,1266.4,1444.9,1256.9L1444.9,1256.9z"/>
                               </g>
                               <g>
                                   <path class="st7" d="M592.3,572.2c-27.8-21.8-51.3-35.6-58.6-57.6c-10.6-32.1,27.5-47.8,41.5-52.7c1.9-0.7,3.6-1,5-1     c9.1,0,9.8,12,12.7,20c3.4,9.2,9.9,13,16.3,16.7c11.4-26.1,22.8-52.1,29.2-52.1c0.6,0,1.2,0.2,1.7,0.7c5.9,5.7,5.1,45.7,4.4,85.6     c84.3,62.2,168.7,124.3,232.9,124.3c11.9,0,23.1-2.1,33.5-6.8c66.4-29.9,99.2-163.3,163.9-229.6c29.1-29.8,64.7-46.1,94.1-46.1     c36,0,62.8,24.3,57.3,78c-10,97.4-126.7,291.5-250.6,329.2c-16,4.9-32.1,7.1-48.3,7.1C817.9,788.1,706.5,675.5,592.3,572.2z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1169,374.2c-4.7,0-9.8,0.3-15.2,1c-29.6,7.1-53.4,19.6-71.5,37.6c-18.1,18.4-30.6,33.4-37.4,45.1     c-14.1,21.6-35.3,59.2-63.7,112.7c-5.6,10-11.4,19.3-17.4,28c5.1,18,11.2,34.8,18.2,50.3c6,15.6,19.3,31,40,46.2     c7.8,6.2,25.2,14.4,52.1,24.4c35.1-33.1,65.5-71.1,91.3-113.9c27.8-46.2,46.6-88.8,56.2-127.6c4.6-18.1,6.2-35,4.8-50.6     c0.2-12.7-6.1-26.2-18.9-40.5C1199.1,378.4,1186.3,374.2,1169,374.2z"/>
                               </g>
                               <g>
                                   <path class="st5" d="M1060.5,564.9L922.2,788c1.7,0,3.4,0.1,5.1,0.1c16.7,0,32.8-2.4,48.4-7.1l30.8-12.5     c20.4-10.5,40.2-24.2,59.2-41.1c2.8-2.6,5.7-5.2,8.4-7.8C1047.1,709.5,1060.5,564.9,1060.5,564.9z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1008.2,760.5l315.5,34.4c18.7-147.8,37.4-295.6-9.3-371.2c-24.5-39.6-67-59.3-110.8-59.3     c-39.8,0-80.6,16.3-110.1,48.7C1031.5,481.3,1019.9,620.9,1008.2,760.5z"/>
                               </g>
                               <g>
                                   <path class="st5" d="M1209.6,525.1l-7.4,256.6l121.4,13.2c7.6-53.8,13.2-105.2,16.7-154.4     C1309.1,610.2,1265.5,571.7,1209.6,525.1z"/>
                               </g>
                               <g>
                                   <path class="st4" d="M1164.6,372.1c-7.1,39.9-14.3,79.9-2.3,79.9c0,0,0,0,0,0c12,0,43-40.1,74.1-80.1     c-10.9-13.5-21.9-27.1-15.9-47.3c5.9-20.2,28.7-47,22.5-62.6c-3.6-9-16.7-14.3-31.3-14.3c-10.7,0-22.1,2.8-31,9.1     c-20.9,14.9-27.7,49-23.5,64.4c4.2,15.4,19.4,12.2,22.5,17.6C1182.8,344.3,1173.7,358.2,1164.6,372.1z"/>
                               </g>
                               <g>
                                   <path class="st6" d="M1192.8,280.4c-10.2,3.7-20.4,7.4-29.8,7.4c-5.2,0-10.1-1.1-14.6-4c-12.8-8.1-22.7-30-20.2-51.1     c2.5-21.1,17.5-41.4,29.2-46.2c2-0.8,3.8-1.2,5.6-1.2c8.8,0,15.8,9,22.7,17.9c9.4-4.9,18.8-9.7,27.3-9.7c1.9,0,3.8,0.2,5.6,0.8     c9.9,3,18.2,14.9,26.6,26.9c10.9,2.8,21.8,5.6,27.4,12.4c5.6,6.8,5.9,17.6,0.6,25.1c-5.4,7.5-16.4,11.7-27.4,15.9     c5.4,10.1,10.7,20.3,5.8,28.9c-4,6.9-14.5,12.8-24.5,12.8c-2.5,0-5-0.4-7.3-1.2C1208.1,310.9,1200.4,295.6,1192.8,280.4z"/>
                               </g>
                               <g>
                                   <path class="st5" d="M1208,323.8L1208,323.8c-4.4,3.6-8,6.3-10.6,7.8c-3.7,2.1-6.4,3.4-8.2,3.8c-2.7,0.8-5.5,1.2-8.4,1.2     c-0.5,0-1.1,0-1.7,0c-0.8,0-1.6,0-2.4,0l0,0c0.2,0.1,0.4,0.1,0.6,0.2c1.1,0.5,1.9,1.2,2.4,2.1l0.5,1.5c0.3,3-1.2,7.6-4.5,13.9     c6.3-2.7,11-5.3,14-7.8C1195.1,342.7,1201.2,335.1,1208,323.8L1208,323.8z"/>
                               </g>
                               <g>
                                   <path class="st8" d="M1040.1,1231.8c-10.4,4.4-22.3-0.5-26.7-10.9L718.6,518.1L691.2,453l-79.3-189.1     c-4.4-10.4,0.5-22.4,10.9-26.7c10.4-4.4,22.3,0.5,26.7,10.9v0l71.3,170l17.2,40.9l313,746     C1055.4,1215.4,1050.5,1227.4,1040.1,1231.8z"/>
                               </g>
                               <polygon class="st5" points="738,459.1 718.6,518.1 691.2,453 720.9,418.1   "/>
                               <g>
                                   <path class="st9" d="M348.7,187.4l-1.3,4.3c-10.1,34.1-15.1,60.8-15,79.9c1.8,39.3,10.7,77.7,26.6,115.1     c36.9,80.5,79.1,122.9,126.8,127.3c73.5,0.9,175.5-28.9,306-89.4c135.7-65.2,208.8-116.4,219.2-153.5     c15.3-41-2.2-91.7-52.4-152.1C906.8,55.2,847.6,18.4,781,8.4C708.5,7.2,631.6,24,550.3,58.8C444.1,103.7,376.9,146.5,348.7,187.4     z"/>
                               </g>
                               <g>
                                   <path class="st8" d="M293.1,187.4l-1.3,4.3c-10.1,34.1-15.1,60.8-15,79.9c1.8,39.3,10.7,77.7,26.6,115.1     c36.9,80.5,79.1,122.9,126.8,127.3c73.5,0.9,175.5-28.9,306-89.4C871.9,359.4,945,308.2,955.4,271.1c15.3-41-2.2-91.7-52.4-152.1     C851.3,55.2,792.1,18.4,725.4,8.4C652.9,7.2,576,24,494.8,58.8C388.6,103.7,321.3,146.5,293.1,187.4z"/>
                               </g>
                               <g>
                                   <path class="st7" d="M976.8,1012.9c-18.3,7.5-36.6,15-51.9,15c-8.9,0-16.8-2.6-23-9.1c-16.9-17.9-21.7-65.5-17.9-82.7     c1.4-6.3,4-8.5,7.1-8.5c5.5,0,12.7,6.6,18.9,10.1c4.4,2.5,8.2,3.4,11.7,3.4c4.2,0,7.9-1.2,11.6-2.5     c-10.6-29.2-21.2-58.5-13.1-58.5c0,0,0,0,0,0c8.2,0.1,35.2,29.6,62.2,59.1c123.4-13.9,246.9-27.7,274-98.3     c27.2-70.6-41.9-197.9-47.1-303.7c-3.7-75.7,25.3-140.5,64.8-140.5c15.7,0,33,10.2,50.6,34.1c61.8,83.8,126.7,335.9,69.2,460.9     c-50.5,110-195.6,121.8-352.2,121.8C1020.4,1013.4,998.6,1013.2,976.8,1012.9z"/>
                               </g>
                               <g>
                                   <path class="st2" d="M1274.4,396.6c-3.2,0-6.5,0.4-9.7,1.3c-33.5,13.9-51.9,54-55.4,120.5c-0.6,9.7,0.3,24.9,2.8,45.5l4.6,27.5     c3.7,17.5,9.5,41.3,17.5,71.6c29.7,8.4,51.3,12.6,64.6,12.6c0.1,0,0.2,0,0.2,0c3.2,0.3,6.4,0.4,9.6,0.4     c18.2,0,36.3-4.8,54.4-14.5c11.4-5.5,24.1-16.4,37.9-32.9c-1.9-9-4-18-6.3-27c-7.2-29-15.5-56.1-24.8-81.2     c-9.3-25.1-19.2-47-29.5-65.5l-15.4-24.3C1307.9,407.9,1291.1,396.6,1274.4,396.6z"/>
                               </g>
                               <path class="st7" d="M645,484c-1.2-40.9-23.6-40.7-27.9-28.9c-4.3,11.7-7.8,42.6-7.8,42.6L645,484z"/>
                               <g>
                                   <path class="st2" d="M423.9,255.4c0,7.4-2.5,14.2-7.5,20.4c-5,6.2-11.9,11.1-20.8,14.5c-8.2,3.2-15.4,4.4-21.7,3.6v-16.2     c5.2,0.4,9.6,0.5,13.1,0.1c3.6-0.4,6.9-1.2,9.8-2.3c3.6-1.4,6.3-3.2,8.2-5.4c1.9-2.2,2.9-4.7,2.9-7.6c0-1.6-0.4-2.9-1.3-3.8     c-0.8-0.9-2.1-1.6-3.7-2.2c-1.6-0.5-4.9-1.1-9.9-1.7c-4.7-0.5-8.2-1.4-10.5-2.7c-2.3-1.3-4.2-3-5.6-5.4c-1.4-2.3-2.1-5.4-2.1-9.3     c0-7.3,2.3-13.9,6.9-19.8c4.6-6,11-10.5,19.1-13.7c4-1.6,7.8-2.5,11.4-3c3.6-0.4,7.4-0.5,11.4-0.2l-5.2,15.6     c-4.1-0.2-7.5-0.1-10.2,0.2c-2.7,0.3-5.3,1-7.9,2c-3.1,1.2-5.4,2.9-7.1,5.1c-1.6,2.2-2.5,4.5-2.5,7c0,1.5,0.3,2.7,1,3.6     c0.7,0.9,1.7,1.6,3.2,2.1c1.5,0.5,4.9,1.1,10.3,1.7c7.2,0.9,12.1,2.6,14.7,5.3C422.6,246,423.9,250,423.9,255.4z"/>
                                   <path class="st2" d="M493,194.7c0,8.8-2.6,16.6-7.7,23.3c-5.2,6.7-12.5,11.9-22,15.6l-7,2.7v29.2l-16.3,6.4v-82.1l24.5-9.6     c9.3-3.6,16.4-4.3,21.2-1.9C490.5,180.7,493,186.2,493,194.7z M456.2,222.1l5.4-2.1c5-2,8.7-4.5,11.2-7.6     c2.5-3.1,3.7-6.7,3.7-10.7c0-4.1-1-6.7-3.1-7.8c-2.1-1.1-5.3-0.8-9.8,0.9l-7.4,2.9V222.1z"/>
                                   <path class="st2" d="M553.8,227.4l-44.2,17.3v-82.1l44.2-17.3v14.3l-27.9,10.9v18l26-10.2v14.3l-26,10.2v21.2l27.9-10.9V227.4z"/>
                                   <path class="st2" d="M604.5,138.7c-6.1,2.4-10.9,6.7-14.2,12.9c-3.4,6.2-5,13.8-5,22.5c0,18.3,6.4,24.9,19.3,19.9     c5.4-2.1,11.9-6.1,19.6-12v14.6c-6.3,5.3-13.3,9.4-21.1,12.5c-11.2,4.4-19.7,4.1-25.6-0.8c-5.9-4.9-8.9-14.2-8.9-27.7     c0-8.5,1.5-16.6,4.4-24.1c2.9-7.6,7.1-14.1,12.5-19.7c5.4-5.6,11.8-9.8,19.1-12.6c7.5-2.9,14.9-3.9,22.5-3l-5.2,16.2     c-2.9-0.3-5.8-0.5-8.7-0.4C610.1,137,607.3,137.6,604.5,138.7z"/>
                                   <path class="st2" d="M642.5,192.6v-82.1l16.3-6.4v82.1L642.5,192.6z"/>
                                   <path class="st2" d="M727.2,159.4l-5.6-17.4l-28,10.9l-5.6,21.7l-17.5,6.9l27.1-93l19.9-7.8l27.2,71.8L727.2,159.4z M717.8,129     c-5.1-15.7-8-24.6-8.7-26.6c-0.6-2.1-1.1-3.7-1.4-5c-1.2,5.2-4.5,18.4-9.9,39.4L717.8,129z"/>
                                   <path class="st2" d="M756.5,148V65.9l16.3-6.4v67.7l31.1-12.2v14.4L756.5,148z"/>
                                   <path class="st2" d="M448.3,365.5c0,13.6-3.1,25.3-9.4,35c-6.3,9.8-15.3,16.9-27.1,21.5c-11.8,4.6-20.8,4.5-27.1-0.3     c-6.3-4.8-9.4-14.1-9.4-27.7c0-13.7,3.2-25.3,9.5-35c6.3-9.7,15.4-16.8,27.2-21.4c11.8-4.6,20.8-4.5,27,0.3     C445.1,342.6,448.3,351.9,448.3,365.5z M392.3,387.4c0,9.2,1.6,15.4,4.9,18.8c3.3,3.4,8.1,3.8,14.6,1.3     c13-5.1,19.5-16.8,19.5-35.3c0-18.5-6.5-25.2-19.4-20.2c-6.5,2.5-11.4,6.8-14.6,12.7C393.9,370.7,392.3,378.2,392.3,387.4z"/>
                                   <path class="st2" d="M482.3,393.3l-16,6.3v-82.1l44-17.2v14.3l-28,10.9v21.2l26-10.2v14.2l-26,10.2V393.3z"/>
                                   <path class="st2" d="M543.4,369.4l-16,6.3v-82.1l44-17.2v14.3l-28,10.9v21.2l26-10.2v14.2l-26,10.2V369.4z"/>
                                   <path class="st2" d="M632.7,334.4l-44.2,17.3v-82.1l44.2-17.3v14.3l-27.9,10.9v18l26-10.2v14.3l-26,10.2V331l27.9-10.9V334.4z"/>
                                   <path class="st2" d="M667.1,289.4v31.5l-16.3,6.4v-82.1l22.4-8.8c10.4-4.1,18.1-5.1,23.1-3c5,2.1,7.5,7.3,7.5,15.6     c0,4.8-1.2,9.6-3.7,14.3c-2.5,4.7-6,9.1-10.5,13c11.5,13.9,19.1,22.9,22.6,26.9l-18,7.1l-18.3-24.3L667.1,289.4z M667.1,275.3     l5.2-2.1c5.1-2,8.9-4.4,11.4-7.2c2.4-2.8,3.7-6.2,3.7-10.1c0-3.9-1.3-6.2-3.8-6.8c-2.5-0.7-6.4,0-11.6,2.1l-4.9,1.9V275.3z"/>
                               </g>
                           </g>
                       </g>
                    </svg>
                    <h1 style="font-weight: 600;" class="text-center">
                        <?php _e('No offers yet'); ?>
                   </h1>
                   <a href="javascript:;" class="btn btn-primary js-add-new-offer"><?php _e('Add new offer'); ?></a>


               </div>





           <?php endif; ?>
       </div>
    </div>

</div>

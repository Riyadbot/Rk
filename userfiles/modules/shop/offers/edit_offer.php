<?php must_have_access(); ?>

<?php


$date_format = get_date_format();
//$products = offers_get_products();


if (isset($params['offer_id']) && $params['offer_id'] !== 'false') {
    $addNew = false;
    //WAS $data = offer_get_by_id($params['offer_id']);
    $data = app()->offer_repository->getById($params['offer_id']);

    if (isset($data['expires_at']) && $data['expires_at'] != '0000-00-00 00:00:00') {
        try {
            $carbonUpdatedAt = Carbon::parse($data['expires_at']);
            $data['expires_at'] = $carbonUpdatedAt->format('Y-m-d');
        } catch (\Exception $e) {
            //
        }
    }
} else {
    $addNew = true;

    $data['id'] = '';
    $data['product_id'] = '';
    $data['product_title'] = '';
    $data['price'] = '';
    $data['price_id'] = '';
    $data['offer_price'] = '';
    $data['created_at'] = '';
    $data['updated_at'] = '';
    $data['expires_at'] = '';
    $data['created_by'] = '';
    $data['edited_by'] = '';
    $data['is_active'] = 1;
}
?>

<script>mw.lib.require('bootstrap_datetimepicker');</script>

<script>
    // SET GLOBAL MULTILANGUAGE TEXTS
    var TEXT_FIELD_MUST_BE_FLOAT_NUMBER = "<?php _ejs('The field must be float number.');?>";
    var TEXT_FIELD_MUST_BE_NUMBER = "<?php _ejs('The field must be number.');?>";
    var TEXT_SUCCESS_SAVE = "<?php _ejs('Offer is saved!');?>";
    var TEXT_FIELD_CANNOT_BE_EMPTY = "<?php _ejs('This field cannot be empty.');?>";
    var TEXT_FILL_ALL_FIELDS = "<?php _ejs('Please fill in all fields correctly.');?>";

    var today = new Date();

    editOferrSetExpirationDate = function () {
        $('[name="expires_at"]', '.js-edit-offer-form').datetimepicker({
            defaultDate: new Date(today.getTime() + (24 * 60 * 60 * 1000)),
            format: '<?php print $date_format;?>',
            //zIndex: 1105
        });
    }

    $(document).ready(function () {
        // editOferrSetExpirationDate();
    });

    function deleteOffer(offer_id) {
        var confirmUser = confirm('<?php _ejs('Are you sure you want to delete this offer?'); ?>');
        if (confirmUser == true) {
            $.ajax({
                url: '<?php print route('api.offer.delete');?>',
                data: 'offer_id=' + offer_id,
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    if (typeof(reload_offer_after_save) != 'undefined') {
                        reload_offer_after_save();
                    }
                    mw.reload_module_everywhere('shop/offers/special_price_field');
                    editModal.modal.remove();
                }
            });
        }
    }
</script>

<div class="js-validation-messages"></div>

<form class="js-edit-offer-form" action="<?php print route('api.offer.store');?>">
    <input type="hidden" name="id" value="<?php print $data['id'] ?>"/>
    <?php if ($addNew) { ?>
        <input type="hidden" name="created_by" value="<?php print user_id() ?>"/>
    <?php } else { ?>
        <input type="hidden" name="edited_by" value="<?php print user_id() ?>"/>
    <?php } ?>

    <div class="form-group d-flex align-items-center justify-content-between" style="width: unset;">
        <label class="form-label"><?php _e("Offer status"); ?></label>
        <div class="form-check form-check-single form-switch" style="width: unset;">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" data-value-checked="y" data-value-unchecked="n" <?php if ($data['is_active'] == 1): ?>checked<?php endif; ?>>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label"><?php _e("Product title | Price"); ?></label>


        <script>
            $(document).ready(function () {
                let offerProduct = new mw.autoComplete({
                    element: "#mw-admin-search-for-products",
                    placeholder: "Search products",
                    ajaxConfig: {
                        method: 'get',
                        url: mw.settings.api_url + 'offers_search_products?keyword=${val}&product_id=<?php print $data['product_id']; ?>&price_id=<?php print $data['price_id']; ?>',
                    },
                    map: {
                        value: 'id',
                        title: 'title',
                        image: 'picture'
                    },
                    selected: [
                        {
                            id: '<?php print $data['product_id']; ?>|<?php print $data['price_id']; ?>',
                            title: '<?php print content_title($data['product_id']); ?> | <?php print currency_format(get_product_price($data['product_id'])); ?>',
                            image: '<?php print get_picture($data['product_id']); ?>'
                        }
                    ]
                });
                $(offerProduct).on("change", function (e, val) {
                    $('#product_id_with_price_id').val(val[0].id);
                    $('#product_id_with_price_id').trigger('change');
                })
            });
        </script>

        <div id="mw-admin-search-for-products"></div>
        <input type="hidden" value="<?php print $data['product_id']; ?>|<?php print $data['price_id']; ?>" id="product_id_with_price_id" name="product_id_with_price_id" />
    </div>

    <div class="form-group">
        <label class="form-label"><?php _e("Offer price"); ?> </label>
        <div class="d-flex align-items-center">

            <div class="input-group mb-2">
                <span class="input-group-text"><?php print mw()->shop_manager->currency_symbol(); ?></span>
                <input type="text" name="offer_price" class="form-control js-validation js-validation-float-number" value="<?php print number_format(floatval($data['offer_price']), 2); ?>"/>
            </div>
        </div>
         <div class="js-field-message"></div>
    </div>

    <div class="d-flex">

        <div class="form-group col-xl-6 pe-xl-2">
            <label class="form-label"><?php _e("Offer start at"); ?></label>
            <small class="text-muted d-block mb-2"><?php _e("Date to start"); ?></small>
            <input type="date" name="created_at" class="form-control" value="<?php print date("Y-m-d H:i:s"); ?>"/>
        </div>

        <div class="form-group col-xl-6 ps-xl-2">
            <label class="form-label"><?php _e("Offer expiration date"); ?></label>
            <small class="text-muted d-block mb-2"><?php _e("Expire date"); ?></small>
            <div class="js-exp-date-holder">
                <input type="date" name="expires_at" class="js-exp-date form-control disabled-js-validation disabled-js-validation-expiry-date" autocomplete="off" value="<?php print ($data['expires_at']); ?>"/>
            </div>
            <div class="js-field-message"></div>
        </div>

    </div>

    <div class="d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="editModal.modal.remove()"><?php _e("Cancel"); ?></button>
        <button type="button" class="btn btn-success btn-sm js-save-offer"><?php _e("Save"); ?></button>
    </div>

</form>
<script type='text/javascript'>

    $(document).ready(function () {
        <?php if (isset($data['product_title'])): ?>
        $(".js-product_title").val("<?php echo $data['product_title']; ?>").change();
        <?php endif; ?>

        $('#expiration-checkbox').on('click',function(e) {

            var checked = $(this).is(":checked");
            var calendarInputEl =  $('.js-exp-date');

            if(checked === false) {
                calendarInputEl.attr('data-old-val', calendarInputEl.val())
                calendarInputEl.val('');
            } else {
                if( calendarInputEl.attr('data-old-val')){
                    calendarInputEl.val(calendarInputEl.attr('data-old-val')).trigger('change');
                }
            }
        });

    });

</script>
<script src="<?php print $config['url_to_module']; ?>js/edit-offer.js"/>


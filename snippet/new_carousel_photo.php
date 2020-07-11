<?php include_once("helper_functions.php"); ?>
<?php
if (! empty($_POST["upload_img_btn"])) {
   if (is_uploaded_file($_FILES['img_file_upload']['tmp_name'])) {
        $ext = pathinfo($_FILES['img_file_upload']['name'],PATHINFO_EXTENSION);
        $new_file_name = "_temp_".date('y_m_d_l_h_i_s_a')."_".time()."_".uniqid().".tmp";
        $targetPath = rel_path_to_abs_path(temp($new_file_name));
        if (move_uploaded_file($_FILES['img_file_upload']['tmp_name'], $targetPath)) {
            $uploaded_img_url = temp_url($new_file_name);
        }
    }
}

if(!empty($_POST["add_slideshow_btn"])){
    $cropped_img_src = $_POST['cropped_img_src'];
    $ext = $_POST['img_ext'];
    $new_file_name = "_slideshow_".date('y_m_d_l_h_i_s_a')."_".time()."_".uniqid().".".$ext;
    $file_name_with_path = rel_path_to_abs_path(uploads($new_file_name));
    file_put_contents($file_name_with_path ,file_get_contents($cropped_img_src));
    website_info()->add_carousel_image($new_file_name);
}


?>

<script src="<?php echo(js_url("jquery.Jcrop.js")); ?>"></script>

<script type="text/javascript">
    jQuery(function ($) {

        // Create variables (in this scope) to hold the API and image size
        var jcrop_api,
            boundx,
            boundy,
            size,

            // Grab some information about the preview pane
            $preview = $('#preview-pane'),
            $pcnt = $('#preview-pane .preview-container'),
            $pimg = $('#preview-pane .preview-container img'),

            xsize = $pcnt.width(),
            ysize = $pcnt.height();

        console.log('init', [xsize, ysize]);


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#target").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#target').Jcrop({
            onChange: updatePreview,
            onSelect: updatePreview,
            aspectRatio: xsize / ysize
        }, function () {
            // Use the API to get the real image size
            var bounds = this.getBounds();
            boundx = bounds[0];
            boundy = bounds[1];
            // Store the API in the jcrop_api variable
            jcrop_api = this;

            // Move the preview into the jcrop container for css positioning
            $preview.appendTo(jcrop_api.ui.holder);
        });

        function updatePreview(c) {
            if (parseInt(c.w) > 0) {
                var rx = xsize / c.w;
                var ry = ysize / c.h;
                $pimg.css({
                    width: Math.round(rx * boundx) + 'px',
                    height: Math.round(ry * boundy) + 'px',
                    marginLeft: '-' + Math.round(rx * c.x) + 'px',
                    marginTop: '-' + Math.round(ry * c.y) + 'px'
                });
            }
            updateSize(c);
        };

        function updateSize(c) {
            var img = document.getElementById("target");

            var w1 = parseInt(img.style.width);
            var h1 = parseInt(img.style.height);

            var w2 = img.naturalWidth;
            var h2 = img.naturalHeight;

            var wc2 = Math.round((w2 / w1) * c.w);
            var hc2 = Math.round((h2 / h1) * c.h);
            var xc2 = Math.round((w2 / w1) * c.x);
            var yc2 = Math.round((h2 / h1) * c.y);

            size = { x: xc2, y: yc2, w: wc2, h: hc2 };
        }

        $("#crop_btn").click(function () {
            var img = $("#target").attr('src');
            $("#crop_div").show();
            var cropped_src = '<?php echo(snippet_url("image-crop.php")) ?>?x=' + size.x + '&y=' + size.y + '&w=' + size.w + '&h=' + size.h + '&img=' + img;
            $("#cropped_slideshow_img").attr('src', cropped_src);
            $("#cropped_img_src").attr('value', cropped_src);
        });


    });


</script>

<link rel="stylesheet" href="<?php echo(css_url("jquery.Jcrop.css")); ?>" type="text/css" />
<style type="text/css">
    /* Apply these styles only when #preview-pane has
   been placed within the Jcrop widget */
    .jcrop-holder #preview-pane {
        display: block;
        position: absolute;
        z-index: 2000;
        top: 10px;
        right: -380px;
        padding: 6px;
        border: 1px rgba(0, 0, 0, .4) solid;
        background-color: white;

        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;

        -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
    }

    /* The Javascript code will set the aspect ratio of the crop
   area based on the size of the thumbnail preview,
   specified here */
    #preview-pane .preview-container {
        width: 300px;
        height: 100px;
        overflow: hidden;
    }
</style>


<div class="container">
    <form class="col-6" action="" method="POST" enctype="multipart/form-data" name="img_upload_form"
        id="img_upload_form">
        <input type="file" name="img_file_upload" id="img_file_upload" class="form-control m-3" accept="image/*" required="required">
        <input type="submit" value="UPLOAD" name="upload_img_btn" id="upload_img_btn" class="btn btn-warning">
    </form>

    <?php if(isset($uploaded_img_url)){ ?>
    <div class="row">
        <div class="span12">
            <div class="jc-demo-box">
                <div class="col-6">
                    <img src="<?php echo($uploaded_img_url);?>" id="target" alt="[Jcrop Example]"
                        style="width:500px;height:250px;" />
                </div>
                <div id="preview-pane">
                    <div class="preview-container">
                        <img src="<?php echo($uploaded_img_url); ?>" class="jcrop-preview"
                            alt="Preview" />
                    </div>
                </div>
                <div class="description m-4">
                    <button type="button" class="btn btn-info" name="crop_btn" id="crop_btn">CROP</button>
                    <form class="col-6" action="" method="POST" enctype="multipart/form-data" name="add_slideshow_form"
                        id="add_slideshow_form">
                        <div style="display: none;" id="crop_div">
                            <img src="#" id="cropped_slideshow_img" name="cropped_slideshow_img"
                                class="border rounded-lg border-dark m-3" style="width:900px;height:240px;">
                            <input type="hidden" name="cropped_img_src" id="cropped_img_src" required="required">
                            <input type="hidden" name="img_ext" id="img_ext" value="<?php echo($ext) ?>" required="required">
                            <input type="submit" value="ADD" class="btn btn-primary" id="add_slideshow_btn"
                                name="add_slideshow_btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
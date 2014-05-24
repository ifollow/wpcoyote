<?php
require_once('get_wp.php');
define('DONOTCACHEPAGE', true);
define('DONOTMINIFY', true);
//<script src="<?php echo site_url(); "></script>
$structure_test = '<div class="admin-item-con">
    <div class="admin-item-header clearfix">
        <h4>Tab</h4>
        <a class="button-header button-delete">
        <span class="icon delete"></span>
        </a>
        <a class="button-header button-edit active">
        <span class="icon pencil"></span>
        </a>
        <div class="clear"></div>
    </div>
    <div class="item-settings">
        <div class="setting">
            <div class="setting-label">Content</div>
            <div class="setting-input type-textarea">
            <textarea class="itemcontent tinymce_enabled" name="itemcontent[]" rows="3" ><img src="'.$dzspb->thepath.'img/sample.jpg" class="fullwidth needs-loading"/></textarea>
        </div>
        </div>
    </div>
    </div>';


$url_admin = get_admin_url();

?>
<!doctype html>
<html lang="en" style="">
    <head>
        <meta charset="utf-8" />
        <title>The title</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo $dzspb->thepath; ?>tinymce/popup.css"/>
        <script src="<?php echo $dzspb->thepath; ?>tinymce/popup_as.js"></script>
        
        <script>
            /*
             * 
             */
            //console.log(window.tinyMCE)
            var dzspb_settings = {
                thepath : "<?php echo $dzspb->thepath; ?>"
                ,startSetup : "<?php if(isset($_GET['sel'])){
                    $aux = $_GET['sel'];
                    
                    $lb = array('"', "\r\n", "\n", "\r", "&", "-", "`", '???', '-');
                    $aux = str_replace($lb, '', $aux);
                    echo $aux; 
                    
                    } ?>"
            }
	if(window.tinyMCE && window.wptinyMCE==undefined)
	{
            window.wptinyMCE = window.tinyMCE;
        }
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
var pagenow = 'dzs_portfolio',
    typenow = 'dzs_portfolio',
    adminpage = 'post-php',
    thousandsSeparator = ',',
    decimalPoint = '.',
    isRtl = 0;
var wordCountL10n = {"type":"w"};
var thickboxL10n = {"next":"Next >","prev":"< Prev","image":"Image","of":"of","close":"Close","noiframes":"This feature requires inline frames. You have iframes disabled or your browser does not support them.","loadingAnimation":"<?php echo site_url(); ?>\/wp-includes\/js\/thickbox\/loadingAnimation.gif","closeImage":"<?php echo site_url(); ?>\/wp-includes\/js\/thickbox\/tb-close.png"};
var commonL10n = {"warnDelete":"You are about to permanently delete the selected items.\n  'Cancel' to stop, 'OK' to delete."};
var wpAjax = {"noPerm":"You do not have permission to do that.","broken":"An unidentified error has occurred."};
var autosaveL10n = {"autosaveInterval":"60","savingText":"Saving Draft\u2026","saveAlert":"The changes you made will be lost if you navigate away from this page.","blog_id":"1"};
var quicktagsL10n = {"closeAllOpenTags":"Close all open tags","closeTags":"close tags","enterURL":"Enter the URL","enterImageURL":"Enter the URL of the image","enterImageDescription":"Enter a description of the image","fullscreen":"fullscreen","toggleFullscreen":"Toggle fullscreen mode","textdirection":"text direction","toggleTextdirection":"Toggle Editor Text Direction"};var adminCommentsL10n = {"hotkeys_highlight_first":"","hotkeys_highlight_last":"","replyApprove":"Approve and Reply","reply":"Reply"};var heartbeatSettings = {"nonce":"ecc15b5e95"};var postL10n = {"ok":"OK","cancel":"Cancel","publishOn":"Publish on:","publishOnFuture":"Schedule for:","publishOnPast":"Published on:","dateFormat":"%1$s %2$s, %3$s @ %4$s : %5$s","showcomm":"Show more comments","endcomm":"No more comments found.","publish":"Publish","schedule":"Schedule","update":"Update","savePending":"Save as Pending","saveDraft":"Save Draft","private":"Private","public":"Public","publicSticky":"Public, Sticky","password":"Password Protected","privatelyPublished":"Privately Published","published":"Published","comma":","};var _wpUtilSettings = {"ajax":{"url":"<?php echo $url_admin; ?>admin-ajax.php"}};var _wpMediaModelsL10n = {"settings":{"ajaxurl":"<?php echo $url_admin; ?>admin-ajax.php","post":{"id":0}}};var pluploadL10n = {"queue_limit_exceeded":"You have attempted to queue too many files.","file_exceeds_size_limit":"%s exceeds the maximum upload size for this site.","zero_byte_file":"This file is empty. Please try another.","invalid_filetype":"This file type is not allowed. Please try another.","not_an_image":"This file is not an image. Please try another.","image_memory_exceeded":"Memory exceeded. Please try another smaller file.","image_dimensions_exceeded":"This is larger than the maximum size. Please try another.","default_error":"An error occurred in the upload. Please try again later.","missing_upload_url":"There was a configuration error. Please contact the server administrator.","upload_limit_exceeded":"You may only upload 1 file.","http_error":"HTTP error.","upload_failed":"Upload failed.","big_upload_failed":"Please try uploading this file with the %1$sbrowser uploader%2$s.","big_upload_queued":"%s exceeds the maximum upload size for the multi-file uploader when used in your browser.","io_error":"IO error.","security_error":"Security error.","file_cancelled":"File canceled.","upload_stopped":"Upload stopped.","dismiss":"Dismiss","crunching":"Crunching\u2026","deleted":"moved to the trash.","error_uploading":"\u201c%s\u201d has failed to upload."};
var _wpPluploadSettings = {"defaults":{"runtimes":"html5,silverlight,flash,html4","file_data_name":"async-upload","multiple_queues":true,"max_file_size":"33554432b","url":"<?php echo $url_admin; ?>async-upload.php","flash_swf_url":"<?php echo site_url(); ?>\/wp-includes\/js\/plupload\/plupload.flash.swf","silverlight_xap_url":"<?php echo site_url(); ?>\/wp-includes\/js\/plupload\/plupload.silverlight.xap","filters":[{"title":"Allowed Files","extensions":"*"}],"multipart":true,"urlstream_upload":true,"multipart_params":{"action":"upload-attachment","_wpnonce":"773ef53e9b"}},"browser":{"mobile":false,"supported":true},"limitExceeded":false};
var _wpMediaViewsL10n = {"url":"URL","addMedia":"Add Media","search":"Search","select":"Select","cancel":"Cancel","selected":"%d selected","dragInfo":"Drag and drop to reorder images.","uploadFilesTitle":"Upload Files","uploadImagesTitle":"Upload Images","mediaLibraryTitle":"Media Library","insertMediaTitle":"Insert Media","createNewGallery":"Create a new gallery","returnToLibrary":"\u2190 Return to library","allMediaItems":"All media items","noItemsFound":"No items found.","insertIntoPost":"Insert into post","uploadedToThisPost":"Uploaded to this post","warnDelete":"You are about to permanently delete this item.\n  'Cancel' to stop, 'OK' to delete.","insertFromUrlTitle":"Insert from URL","setFeaturedImageTitle":"Set Featured Image","setFeaturedImage":"Set featured image","createGalleryTitle":"Create Gallery","editGalleryTitle":"Edit Gallery","cancelGalleryTitle":"\u2190 Cancel Gallery","insertGallery":"Insert gallery","updateGallery":"Update gallery","addToGallery":"Add to gallery","addToGalleryTitle":"Add to Gallery","reverseOrder":"Reverse order","settings":{"tabs":[],"tabUrl":"<?php echo $url_admin; ?>media-upload.php?chromeless=1","mimeTypes":{"image":"Images","audio":"Audio","video":"Video"},"captions":true,"nonce":{"sendToEditor":"0aef7a9d93"},"post":{"id":3905,"nonce":"0ba07d0c8c","featuredImageId":"3577"},"defaultProps":{"link":"","align":"","size":""},"embedExts":["mp3","ogg","wma","m4a","wav","mp4","m4v","webm","ogv","wmv","flv"]}};var authcheckL10n = {"beforeunload":"Your session has expired. You can log in again from this page or go to the login page.","interval":"180"};var wordCountL10n = {"type":"w"};var wpLinkL10n = {"title":"Insert\/edit link","update":"Update","save":"Add Link","noTitle":"(no title)","noMatchesFound":"No matches found."};/* ]]> */
</script>
        <script src="<?php echo $dzspb->thepath; ?>tinymce/jscripts/tiny_mce/tinymce.js"></script>
        <script src="<?php echo $dzspb->thepath; ?>tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
        <!--
        <script type="text/javascript" src="http://localhost/tinymce_jquery/jscripts/tiny_mce/jquery.tinymce.js"></script>
        <script src="<?php echo $dzspb->thepath; ?>tinymce/js/tiny_mce.js"></script>
        -->
        <?php //wp_head(); ?>
        <script type='text/javascript' src='<?php echo $url_admin; ?>load-scripts.php?c=1&amp;load%5B%5D=utils,plupload,plupload-html5,plupload-flash,plupload-silverlight,plupload-html4,json2&amp;ver=3.6.1'></script>
        <script type='text/javascript' src='<?php echo $url_admin; ?>load-scripts.php?c=1&amp;load%5B%5D=thickbox,jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-sortable,jquery-ui-draggable,jquery-ui-droppable,&amp;load%5B%5D=common,admin-bar,schedule,wp-ajax-response,autosave,wp-lists,admin-comments,suggest,postbox,&amp;load%5B%5D=heartbeat,underscore,shortcode,backbone,wp-util,wp-backbone,media-models,wp-plupload,media-views,media-editor,wp-auth-check&amp;load%5B%5D=,word-count,editor,jquery-ui-resizable,jquery-ui-button,jquery-ui-position,jquery-ui-dialog,wpdialogs,wplink,wpdialogs-popup,wp-&amp;load%5B%5D=fullscreen,media-upload&amp;ver=3.6.1'></script>
        
    </head>
    <body class="testimonial-admin">
        <div class="misc-init-setup">
        <?php if(isset($_GET['sel']) && $_GET['sel']!=''){
            echo '<h4>Initial Setup</h4>';
            echo $_GET['sel'];
            echo '<div class="hidden init-setup-transformed">'.do_shortcode($_GET['sel']).'</div>';
            echo '<script>jQuery(".init-setup-transformed").children(".dzs-tabs").eq(0).attr("id", "").attr("class", "justfortest"); 
                //jQuery(".init-setup-transformed").children("script").remove();
                </script>';
        }?>
            </div>
        <div class="maincon">
            <form class="settings one_half" id="mainsettings" method="POST">
                <h3 class="maintitle">Advanced Tabs Settings</h3>
                
                <button id="add_admin_item" class="ui-button">Add Item</button>
                <button id="insert_admin_item" class="ui-button">Insert Items In Editor</button>
                <br/><br/>
    <div class="setting">
        <div class="setting-label">Width & Height</div>
        <div class="sidenote">recommended - leave blank or 0- default is auto width and height</div>
        <div class="setting-input type-input">
        <input name="settings_width" value=""/>&nbsp;<input name="settings_height" value=""/>
        </div>
    </div>
                <!--
    <div class="setting">
        <div class="setting-label">Slideshow Time</div>
        <div class="setting-input type-input">
        <input name="settings_slideshowtime" value="5"/>
        </div>
    </div>
               --> 
                <div class="admin_items_con">
                    
                </div>
               <div class="output-div"></div>
         
            </form>
            <div class="preview one_half last">
                <div class="preview-header">
                    <h3>Preview   </h3>
                    <button id="but_preview" class="ui-button">Refresh Preview</button>
                    <div class="clear"></div>
                </div>
                <div class="preview-inner">
                   Here is a preview of the settings you choose. Updates every 4 secs. 
                </div>
            </div>
            <div class="clear"></div>
        </div>
        
        
        
        
        
        <script type="text/javascript">if(typeof wpOnload=='function'){
    wpOnload();;
}</script>


<script type="text/html" id="tmpl-media-frame">
        <div class="media-frame-menu"></div>
        <div class="media-frame-title"></div>
        <div class="media-frame-router"></div>
        <div class="media-frame-content"></div>
        <div class="media-frame-toolbar"></div>
        <div class="media-frame-uploader"></div>
    </script>

    <script type="text/html" id="tmpl-media-modal">
        <div class="media-modal wp-core-ui">
            <a class="media-modal-close" href="#" title="Close"><span class="media-modal-icon"></span></a>
            <div class="media-modal-content"></div>
        </div>
        <div class="media-modal-backdrop"></div>
    </script>

    <script type="text/html" id="tmpl-uploader-window">
        <div class="uploader-window-content">
            <h3>Drop files to upload</h3>
        </div>
    </script>

    <script type="text/html" id="tmpl-uploader-inline">
        <# var messageClass = data.message ? 'has-upload-message' : 'no-upload-message'; #>
        <div class="uploader-inline-content {{ messageClass }}">
        <# if ( data.message ) { #>
            <h3 class="upload-message">{{ data.message }}</h3>
        <# } #>
                    <div class="upload-ui">
                <h3 class="upload-instructions drop-instructions">Drop files anywhere to upload</h3>
                <a href="#" class="browser button button-hero">Select Files</a>
            </div>

            <div class="upload-inline-status"></div>

            <div class="post-upload-ui">
                
                <p class="max-upload-size">Maximum upload file size: 32MB.</p>

                
                            </div>
                </div>
    </script>

    <script type="text/html" id="tmpl-uploader-status">
        <h3>Uploading</h3>
        <a class="upload-dismiss-errors" href="#">Dismiss Errors</a>

        <div class="media-progress-bar"><div></div></div>
        <div class="upload-details">
            <span class="upload-count">
                <span class="upload-index"></span> / <span class="upload-total"></span>
            </span>
            <span class="upload-detail-separator">&ndash;</span>
            <span class="upload-filename"></span>
        </div>
        <div class="upload-errors"></div>
    </script>

    <script type="text/html" id="tmpl-uploader-status-error">
        <span class="upload-error-label">Error</span>
        <span class="upload-error-filename">{{{ data.filename }}}</span>
        <span class="upload-error-message">{{ data.message }}</span>
    </script>

    <script type="text/html" id="tmpl-attachment">
        <div class="attachment-preview type-{{ data.type }} subtype-{{ data.subtype }} {{ data.orientation }}">
            <# if ( data.uploading ) { #>
                <div class="media-progress-bar"><div></div></div>
            <# } else if ( 'image' === data.type ) { #>
                <div class="thumbnail">
                    <div class="centered">
                        <img src="{{ data.size.url }}" draggable="false" />
                    </div>
                </div>
            <# } else { #>
                <img src="{{ data.icon }}" class="icon" draggable="false" />
                <div class="filename">
                    <div>{{ data.filename }}</div>
                </div>
            <# } #>

            <# if ( data.buttons.close ) { #>
                <a class="close media-modal-icon" href="#" title="Remove"></a>
            <# } #>

            <# if ( data.buttons.check ) { #>
                <a class="check" href="#" title="Deselect"><div class="media-modal-icon"></div></a>
            <# } #>
        </div>
        <#
        var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly';
        if ( data.describe ) { #>
            <# if ( 'image' === data.type ) { #>
                <input type="text" value="{{ data.caption }}" class="describe" data-setting="caption"
                    placeholder="Caption this image&hellip;" {{ maybeReadOnly }} />
            <# } else { #>
                <input type="text" value="{{ data.title }}" class="describe" data-setting="title"
                    <# if ( 'video' === data.type ) { #>
                        placeholder="Describe this video&hellip;"
                    <# } else if ( 'audio' === data.type ) { #>
                        placeholder="Describe this audio file&hellip;"
                    <# } else { #>
                        placeholder="Describe this media file&hellip;"
                    <# } #> {{ maybeReadOnly }} />
            <# } #>
        <# } #>
    </script>

    <script type="text/html" id="tmpl-attachment-details">
        <h3>
            Attachment Details
            <span class="settings-save-status">
                <span class="spinner"></span>
                <span class="saved">Saved.</span>
            </span>
        </h3>
        <div class="attachment-info">
            <div class="thumbnail">
                <# if ( data.uploading ) { #>
                    <div class="media-progress-bar"><div></div></div>
                <# } else if ( 'image' === data.type ) { #>
                    <img src="{{ data.size.url }}" draggable="false" />
                <# } else { #>
                    <img src="{{ data.icon }}" class="icon" draggable="false" />
                <# } #>
            </div>
            <div class="details">
                <div class="filename">{{ data.filename }}</div>
                <div class="uploaded">{{ data.dateFormatted }}</div>

                <# if ( 'image' === data.type && ! data.uploading ) { #>
                    <# if ( data.width && data.height ) { #>
                        <div class="dimensions">{{ data.width }} &times; {{ data.height }}</div>
                    <# } #>

                    <# if ( data.can.save ) { #>
                        <a class="edit-attachment" href="{{ data.editLink }}&amp;image-editor" target="_blank">Edit Image</a>
                        <a class="refresh-attachment" href="#">Refresh</a>
                    <# } #>
                <# } #>

                <# if ( data.fileLength ) { #>
                    <div class="file-length">Length: {{ data.fileLength }}</div>
                <# } #>

                <# if ( ! data.uploading && data.can.remove ) { #>
                    <a class="delete-attachment" href="#">Delete Permanently</a>
                <# } #>

                <div class="compat-meta">
                    <# if ( data.compat && data.compat.meta ) { #>
                        {{{ data.compat.meta }}}
                    <# } #>
                </div>
            </div>
        </div>

        <# var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly'; #>
            <label class="setting" data-setting="title">
                <span>Title</span>
                <input type="text" value="{{ data.title }}" {{ maybeReadOnly }} />
            </label>
            <label class="setting" data-setting="caption">
                <span>Caption</span>
                <textarea {{ maybeReadOnly }}>{{ data.caption }}</textarea>
            </label>
        <# if ( 'image' === data.type ) { #>
            <label class="setting" data-setting="alt">
                <span>Alt Text</span>
                <input type="text" value="{{ data.alt }}" {{ maybeReadOnly }} />
            </label>
        <# } #>
            <label class="setting" data-setting="description">
                <span>Description</span>
                <textarea {{ maybeReadOnly }}>{{ data.description }}</textarea>
            </label>
    </script>

    <script type="text/html" id="tmpl-media-selection">
        <div class="selection-info">
            <span class="count"></span>
            <# if ( data.editable ) { #>
                <a class="edit-selection" href="#">Edit</a>
            <# } #>
            <# if ( data.clearable ) { #>
                <a class="clear-selection" href="#">Clear</a>
            <# } #>
        </div>
        <div class="selection-view"></div>
    </script>

    <script type="text/html" id="tmpl-attachment-display-settings">
        <h3>Attachment Display Settings</h3>

        <# if ( 'image' === data.type ) { #>
            <label class="setting">
                <span>Alignment</span>
                <select class="alignment"
                    data-setting="align"
                    <# if ( data.userSettings ) { #>
                        data-user-setting="align"
                    <# } #>>

                    <option value="left">
                        Left                    </option>
                    <option value="center">
                        Center                  </option>
                    <option value="right">
                        Right                   </option>
                    <option value="none" selected>
                        None                    </option>
                </select>
            </label>
        <# } #>

        <div class="setting">
            <label>
                <# if ( data.model.canEmbed ) { #>
                    <span>Embed or Link</span>
                <# } else { #>
                    <span>Link To</span>
                <# } #>

                <select class="link-to"
                    data-setting="link"
                    <# if ( data.userSettings && ! data.model.canEmbed ) { #>
                        data-user-setting="urlbutton"
                    <# } #>>

                <# if ( data.model.canEmbed ) { #>
                    <option value="embed" selected>
                        Embed Media Player                  </option>
                    <option value="file">
                <# } else { #>
                    <option value="file" selected>
                <# } #>
                    <# if ( data.model.canEmbed ) { #>
                        Link to Media File                  <# } else { #>
                        Media File                  <# } #>
                    </option>
                    <option value="post">
                    <# if ( data.model.canEmbed ) { #>
                        Link to Attachment Page                 <# } else { #>
                        Attachment Page                 <# } #>
                    </option>
                <# if ( 'image' === data.type ) { #>
                    <option value="custom">
                        Custom URL                  </option>
                    <option value="none">
                        None                    </option>
                <# } #>
                </select>
            </label>
            <input type="text" class="link-to-custom" data-setting="linkUrl" />
        </div>

        <# if ( 'undefined' !== typeof data.sizes ) { #>
            <label class="setting">
                <span>Size</span>
                <select class="size" name="size"
                    data-setting="size"
                    <# if ( data.userSettings ) { #>
                        data-user-setting="imgsize"
                    <# } #>>
                                            <#
                        var size = data.sizes['thumbnail'];
                        if ( size ) { #>
                            <option value="thumbnail" >
                                Thumbnail &ndash; {{ size.width }} &times; {{ size.height }}
                            </option>
                        <# } #>
                                            <#
                        var size = data.sizes['medium'];
                        if ( size ) { #>
                            <option value="medium" >
                                Medium &ndash; {{ size.width }} &times; {{ size.height }}
                            </option>
                        <# } #>
                                            <#
                        var size = data.sizes['large'];
                        if ( size ) { #>
                            <option value="large" >
                                Large &ndash; {{ size.width }} &times; {{ size.height }}
                            </option>
                        <# } #>
                                            <#
                        var size = data.sizes['full'];
                        if ( size ) { #>
                            <option value="full"  selected='selected'>
                                Full Size &ndash; {{ size.width }} &times; {{ size.height }}
                            </option>
                        <# } #>
                                    </select>
            </label>
        <# } #>
    </script>

    <script type="text/html" id="tmpl-gallery-settings">
        <h3>Gallery Settings</h3>

        <label class="setting">
            <span>Link To</span>
            <select class="link-to"
                data-setting="link"
                <# if ( data.userSettings ) { #>
                    data-user-setting="urlbutton"
                <# } #>>

                <option value="post" selected>
                    Attachment Page             </option>
                <option value="file">
                    Media File              </option>
                <option value="none">
                    None                </option>
            </select>
        </label>

        <label class="setting">
            <span>Columns</span>
            <select class="columns" name="columns"
                data-setting="columns">
                                    <option value="1" >
                        1                   </option>
                                    <option value="2" >
                        2                   </option>
                                    <option value="3"  selected='selected'>
                        3                   </option>
                                    <option value="4" >
                        4                   </option>
                                    <option value="5" >
                        5                   </option>
                                    <option value="6" >
                        6                   </option>
                                    <option value="7" >
                        7                   </option>
                                    <option value="8" >
                        8                   </option>
                                    <option value="9" >
                        9                   </option>
                            </select>
        </label>

        <label class="setting">
            <span>Random Order</span>
            <input type="checkbox" data-setting="_orderbyRandom" />
        </label>
    </script>

    <script type="text/html" id="tmpl-embed-link-settings">
        <label class="setting">
            <span>Title</span>
            <input type="text" class="alignment" data-setting="title" />
        </label>
    </script>

    <script type="text/html" id="tmpl-embed-image-settings">
        <div class="thumbnail">
            <img src="{{ data.model.url }}" draggable="false" />
        </div>

                    <label class="setting caption">
                <span>Caption</span>
                <textarea data-setting="caption" />
            </label>
        
        <label class="setting alt-text">
            <span>Alt Text</span>
            <input type="text" data-setting="alt" />
        </label>

        <div class="setting align">
            <span>Align</span>
            <div class="button-group button-large" data-setting="align">
                <button class="button" value="left">
                    Left                </button>
                <button class="button" value="center">
                    Center              </button>
                <button class="button" value="right">
                    Right               </button>
                <button class="button active" value="none">
                    None                </button>
            </div>
        </div>

        <div class="setting link-to">
            <span>Link To</span>
            <div class="button-group button-large" data-setting="link">
                <button class="button" value="file">
                    Image URL               </button>
                <button class="button" value="custom">
                    Custom URL              </button>
                <button class="button active" value="none">
                    None                </button>
            </div>
            <input type="text" class="link-to-custom" data-setting="linkUrl" />
        </div>
    </script>

    <script type="text/html" id="tmpl-attachments-css">
        <style type="text/css" id="{{ data.id }}-css">
            #{{ data.id }} {
                padding: 0 {{ data.gutter }}px;
            }

            #{{ data.id }} .attachment {
                margin: {{ data.gutter }}px;
                width: {{ data.edge }}px;
            }

            #{{ data.id }} .attachment-preview,
            #{{ data.id }} .attachment-preview .thumbnail {
                width: {{ data.edge }}px;
                height: {{ data.edge }}px;
            }

            #{{ data.id }} .portrait .thumbnail img {
                max-width: {{ data.edge }}px;
                height: auto;
            }

            #{{ data.id }} .landscape .thumbnail img {
                width: auto;
                max-height: {{ data.edge }}px;
            }
        </style>
    </script>
        <div id="local-storage-notice" class="hidden">
    <p class="local-restore">
        The backup of this post in your browser is different from the version below.        <a class="restore-backup" href="#">Restore the backup.</a>
    </p>
    <p class="undo-restore hidden">
        Post restored successfully.     <a class="undo-restore-backup" href="#">Undo.</a>
    </p>
    </div>
        <link rel='stylesheet' href='<?php echo $url_admin; ?>load-styles.php?c=1&amp;dir=ltr&amp;load=admin-bar,buttons,media-views,wp-admin,wp-auth-check,farbtastic&amp;ver=3.6.1' type='text/css' media='all' />
        
        
        
        
        
        <script>
        <?php
        
        $aux = str_replace(array("\r", "\r\n", "\n"), '', $structure_test);
        echo "var structure_test = '".$aux."';
";?>
        </script>
        <!--
        <script src="<?php echo site_url(); ?>/wp-admin/js/word-count.js"></script>
        <script src="<?php echo site_url(); ?>/wp-admin/js/utils.js"></script>
        <script src="<?php echo site_url(); ?>/wp-admin/js/editor.js"></script>
<script type='text/javascript' src='<?php echo site_url(); ?>/wp-includes/js/thickbox/thickbox.js?ver=3.1-20111117'></script>
<script type='text/javascript' src='<?php echo site_url(); ?>/wp-admin/js/media-upload.js?ver=3.4.1'></script>
        -->
        <link rel="stylesheet" type="text/css" href="<?php echo $dzspb->thepath; ?>advancedscroller/plugin.css"/>
        <script src="<?php echo $dzspb->thepath; ?>advancedscroller/plugin.js"></script>
        
        </body>
</html>
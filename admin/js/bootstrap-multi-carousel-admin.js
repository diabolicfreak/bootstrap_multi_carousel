(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    /**
     * Check if slides_array is present, if present json parse data
     */
    console.log("slides before parse "+angular.toJson(slides_array));
    if(slides_array==""){
        console.log("no slides_array");
    }else {
        console.log("data present");
        var slides = JSON.parse(slides_array) || JSON.parse(JSON.stringify(slides_array));
    }
    console.log("slides after parse "+angular.toJson(slides));

    /**
     * Admin side angular module
     * @param  {[type]} 'BMCAdmin' [description]
     * @param  {[type]} []         [description]
     * @return {[type]}            [description]
     */
    angular.module('BMCAdmin', []);
    angular.module('BMCAdmin')
        .controller('BMCAdminController', ['$scope', function($scope){
            /**
             * Process slides data recieved from database
             */
            $scope.slides = slides;
            console.log("inside contr "+angular.toJson($scope.slides));
            if(!(angular.isArray($scope.slides)) || $scope.slides.length == 0 || $scope.slides==""){
                $scope.slides = [];
                $scope.slides.push({});
                $scope.slides[0].order = 0;
                $scope.slides[0].url = "";
                console.log("$scope.slides[0].name "+$scope.slides[0].name);
            }

            //Add a new slide - OnClick 'Add new slide'
            $scope.addSlide = function(){
                $scope.slides.push(
                    {
                        order: $scope.slides.length,
                        url: ""

                    }
                );
                console.log($scope.slides);
            }

            //Pick an image from the media uploader - OnClick 'Upload Slide'
            $scope.imageUpload = function(slide){
                // Display the media uploader
                // renderMediaUploader($);
                var file_frame, image_data;

                /**
                 * If an instance of file_frame already exists, then we can open it
                 * rather than creating a new instance.
                 */
                if ( undefined !== file_frame ) {

                    file_frame.open();
                    return;

                }

                /**
                 * If we're this far, then an instance does not exist, so we need to
                 * create our own.
                 *
                 * Here, use the wp.media library to define the settings of the Media
                 * Uploader. We're opting to use the 'post' frame which is a template
                 * defined in WordPress core and are initializing the file frame
                 * with the 'insert' state.
                 *
                 * We're also not allowing the user to select more than one image.
                 */
                file_frame = wp.media.frames.file_frame = wp.media({
                    frame:    'post',
                    state:    'insert',
                    multiple: false
                });

                /**
                 * Setup an event handler for what to do when an image has been
                 * selected.
                 *
                 * Since we're using the 'view' state when initializing
                 * the file_frame, we need to make sure that the handler is attached
                 * to the insert event.
                 */
                file_frame.on( 'insert', function() {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    //  $('#image-url').val(attachment.url);

                    var input = $('input[name="acme_footer_slides['+$scope.slides.indexOf(slide)+']"]');
                    input.val(attachment.url);
                    input.trigger('input');

                    console.log(this);
                    // slide.url = attachment.url;
                    console.log("slide "+angular.toJson(slide));
                });

                // Now display the actual file_frame
                file_frame.open();
            }

            //Delete current slide
            $scope.deleteSlide = function(slide){
                $scope.slides.splice($scope.slides.indexOf(slide),1);
            }

            //Final save slides - onClick 'Save Changes'
            $scope.submitformhandler = function(){
                console.log("$scope.slides before submit "+angular.toJson($scope.slides));
                $scope.slidesUrl = [];
                angular.forEach($scope.slides, function(slide, key){
                    $scope.slidesUrl.push(slide.url);
                })

                console.log("$scope.slidesUrl "+angular.toJson($scope.slidesUrl));
                //Send ajax request to save slides
                jQuery.post(
                    ajaxurl,
                    {
                        'action': 'save_BMCslides',
                        // 'option'    : 'acme_footer_slides',
                        'slides_array' :   angular.toJson($scope.slides),
                        // 'slide_url_array_key': 'slide_url_only_array',
                        'slide_url_only_array': angular.toJson($scope.slidesUrl)
                    },
                    function(response, status){
                        console.log('The server responded: ' + status);
                        if(status == 'success'){
                            $('.message-success').fadeIn().delay(1500).fadeOut();
                        }
                        else {
                            $('.message-error').fadeIn().delay(1500).fadeOut();
                        }
                    }
                );
            }


        }]);

})( jQuery );

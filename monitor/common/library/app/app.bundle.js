var smartadmin;

smartadmin = {
	colors: {
		"blue": "#3276b1",
		"blue-sky":  "#0091d9",
		"bg-blue": "#57889c",
		"blue-light": "#92a2a8",
		"blue-dark": "#4c4f53",
		"green": "#356e35",
		"green-light": "#71843f",
		"green-dark": "#496949",
		"green-bright": "#40ac2b",
		"green-bright-1": "#aafaaf",
		"red": "#a90329",
		"yellow": "#b09b5b",
		"orange" : "#c79121",
		"orange-dark": "#a57225",
		"orange-bright":  "#ffc40d",
		"pink": "#ac5287;",
		"pink-dark": "#a8829f",
		"purple": "#6e587a",
		"offwhite": "#f8f8f8",
		"darken": "#404040",
		"lighten":   "#d5e7ec",
		"white": "#ffffff",
		"gray-dark": "#525252",
		"magenta": "#6e3671;",
		"primary": "#3276b1",
		"success": "#739e73",
		"danger": "#a90329",
		"teal": "#568a89",
		"red-light": "#a65858",
		"red-bright": "#ed1c24",
		"teal-light": "#0aa66e",
		"warning": "#c09853",
		"blue-light2": "#058dc7",
		"btnBlue": "#57889c",
		"light": "#fff",
		"dark": "#494949",
		"lightYellow": "#FFFFE0",
		"light-gray": "#A0A0A0",
		"brown": "#797979"
	},
	classesName: {
		fullScreen: 'sa-full-screen',
		shortcutsSection: 'sa-shortcuts-section'
	},

	toggleReloadButton : {

		resetHTML 	: "<i class=\"fa fa-refresh\"></i>",
		loadingHTML : "<i class=\"fa fa-refresh fa-spin\"></i> Loading..."
	},

	trunOnFullScreen: function(){

		if (document.documentElement.requestFullScreen) {  

	      document.documentElement.requestFullScreen();  

	    } else if (document.documentElement.mozRequestFullScreen) {  

	      document.documentElement.mozRequestFullScreen();  

	    } else if (document.documentElement.webkitRequestFullScreen) {  

	      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  

	    }
	    $('body').addClass(smartadmin.classesName.fullScreen); 

	},

	trunOffFullScreen: function(){

		if (document.cancelFullScreen) {  

	      document.cancelFullScreen();  

	    } else if (document.mozCancelFullScreen) {  

	      document.mozCancelFullScreen();  

	    } else if (document.webkitCancelFullScreen) {  

	      document.webkitCancelFullScreen();  

	    }

	    $('body').removeClass(smartadmin.classesName.fullScreen);

	},

	launchFullscreen: function() {

     if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {

	    this.trunOnFullScreen();

	  } else {  
	  	this.trunOffFullScreen();    

	  } 

    },
    // RESET WIDGETS
	resetWidgets: function($this){
		
		$.SmartMessageBox({
			title : "<i class='fa fa-refresh' style='color:green'></i> Clear Local Storage",
			content : $this.data('reset-msg') || "Would you like to RESET all your saved widgets and clear LocalStorage?1",
			buttons : '[No][Yes]'
		}, function(ButtonPressed) {
			if (ButtonPressed == "Yes" && localStorage) {
				localStorage.clear();
				location.reload();
			}

		});
	}
}

jQuery.fn.doesExist=function(){return jQuery(this).length>0}
/*
 * =======================================================================
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * =======================================================================
 * original filename: app.config.js
 * filesize: 12kb
 * =======================================================================
 * 
 * GLOBAL ROOT (DO NOT CHANGE)
 */
	$.root_ = $('body');	
/*
 * APP CONFIGURATION (HTML/AJAX/PHP Versions ONLY)
 * Description: Enable / disable certain theme features here
 * GLOBAL: Your left nav in your app will no longer fire ajax calls, set 
 * it to false for HTML version
 */	
	$.navAsAjax = false; 
/*
 * GLOBAL: Sound Config (define sound path, enable or disable all sounds)
 */
	$.sound_path = "sound/";
	$.sound_on = true; 
/*
 * SAVE INSTANCE REFERENCE (DO NOT CHANGE)
 * Save a reference to the global object (window in the browser)
 */
	var root = this,	
/*
 * DEBUGGING MODE
 * debugState = true; will spit all debuging message inside browser console.
 * The colors are best displayed in chrome browser.
 */
	debugState = false,	
	debugStyle = 'font-weight: bold; color: #00f;',
	debugStyle_green = 'font-weight: bold; font-style:italic; color: #46C246;',
	debugStyle_red = 'font-weight: bold; color: #ed1c24;',
	debugStyle_warning = 'background-color:yellow',
	debugStyle_success = 'background-color:green; font-weight:bold; color:#fff;',
	debugStyle_error = 'background-color:#ed1c24; font-weight:bold; color:#fff;',
/*
 * Impacts the responce rate of some of the responsive elements (lower 
 * value affects CPU but improves speed)
 */
	throttle_delay = 350,
/*
 * The rate at which the menu expands revealing child elements on click
 */
	menu_speed = 235,	
/*
 * Collapse current menu item as other menu items are expanded
 * Careful when using this option, if you have a long menu it will
 * keep expanding and may distrupt the user experience This is best 
 * used with fixed-menu class
 */
	menu_accordion = true,	
/*
 * Turn on JarvisWidget functionality
 * Global JarvisWidget Settings
 * For a greater control of the widgets, please check app.js file
 * found within COMMON_ASSETS/UNMINIFIED_JS folder and see from line 1355
 * dependency: js/jarviswidget/jarvis.widget.min.js
 */
	enableJarvisWidgets = true,
/*
 * Use localstorage to save widget settings
 * turn this off if you prefer to use the onSave hook to save
 * these settings to your datatabse instead
 */	
	localStorageJarvisWidgets = true,
/*
 * Turn off sortable feature for JarvisWidgets 
 */	
	sortableJarvisWidgets = true,		
/*
 * Warning: Enabling mobile widgets could potentially crash your webApp 
 * if you have too many widgets running at once 
 * (must have enableJarvisWidgets = true)
 */
	enableMobileWidgets = false,	
/*
 * Turn on fast click for mobile devices
 * Enable this to activate fastclick plugin
 * dependency: js/plugin/fastclick/fastclick.js 
 */
	fastClick = false,
/*
 * SMARTCHAT PLUGIN ARRAYS & CONFIG
 * Dependency: js/plugin/moment/moment.min.js 
 *             js/plugin/cssemotions/jquery.cssemoticons.min.js 
 *             js/smart-chat-ui/smart.chat.ui.js
 * (DO NOT CHANGE BELOW) 
 */	
	boxList = [],
	showList = [],
 	nameList = [],
	idList = [],
/*
 * Width of the chat boxes, and the gap inbetween in pixel (minus padding)
 */	
	chatbox_config = {
	    width: 200,
	    gap: 35
	},
/*
 * These elements are ignored during DOM object deletion for ajax version 
 * It will delete all objects during page load with these exceptions:
 */
	ignore_key_elms = ["#header, #left-panel, #right-panel, #main, div.page-footer, #shortcut, #divSmallBoxes, #divMiniIcons, #divbigBoxes, #voiceModal, script, .ui-chatbox"],
/*
 * VOICE COMMAND CONFIG
 * dependency: js/speech/voicecommand.js
 */
	voice_command = true,
/*
 * Turns on speech as soon as the page is loaded
 */	
	voice_command_auto = false,
/*
 * 	Sets the language to the default 'en-US'. (supports over 50 languages 
 * 	by google)
 * 
 *  Afrikaans         ['af-ZA']
 *  Bahasa Indonesia  ['id-ID']
 *  Bahasa Melayu     ['ms-MY']
 *  Català            ['ca-ES']
 *  Čeština           ['cs-CZ']
 *  Deutsch           ['de-DE']
 *  English           ['en-AU', 'Australia']
 *                    ['en-CA', 'Canada']
 *                    ['en-IN', 'India']
 *                    ['en-NZ', 'New Zealand']
 *                    ['en-ZA', 'South Africa']
 *                    ['en-GB', 'United Kingdom']
 *                    ['en-US', 'United States']
 *  Español           ['es-AR', 'Argentina']
 *                    ['es-BO', 'Bolivia']
 *                    ['es-CL', 'Chile']
 *                    ['es-CO', 'Colombia']
 *                    ['es-CR', 'Costa Rica']
 *                    ['es-EC', 'Ecuador']
 *                    ['es-SV', 'El Salvador']
 *                    ['es-ES', 'España']
 *                    ['es-US', 'Estados Unidos']
 *                    ['es-GT', 'Guatemala']
 *                    ['es-HN', 'Honduras']
 *                    ['es-MX', 'México']
 *                    ['es-NI', 'Nicaragua']
 *                    ['es-PA', 'Panamá']
 *                    ['es-PY', 'Paraguay']
 *                    ['es-PE', 'Perú']
 *                    ['es-PR', 'Puerto Rico']
 *                    ['es-DO', 'República Dominicana']
 *                    ['es-UY', 'Uruguay']
 *                    ['es-VE', 'Venezuela']
 *  Euskara           ['eu-ES']
 *  Français          ['fr-FR']
 *  Galego            ['gl-ES']
 *  Hrvatski          ['hr_HR']
 *  IsiZulu           ['zu-ZA']
 *  Íslenska          ['is-IS']
 *  Italiano          ['it-IT', 'Italia']
 *                    ['it-CH', 'Svizzera']
 *  Magyar            ['hu-HU']
 *  Nederlands        ['nl-NL']
 *  Norsk bokmål      ['nb-NO']
 *  Polski            ['pl-PL']
 *  Português         ['pt-BR', 'Brasil']
 *                    ['pt-PT', 'Portugal']
 *  Română            ['ro-RO']
 *  Slovenčina        ['sk-SK']
 *  Suomi             ['fi-FI']
 *  Svenska           ['sv-SE']
 *  Türkçe            ['tr-TR']
 *  български         ['bg-BG']
 *  Pусский           ['ru-RU']
 *  Српски            ['sr-RS']
 *  한국어          ['ko-KR']
 *  中文                            ['cmn-Hans-CN', '普通话 (中国大陆)']
 *                    ['cmn-Hans-HK', '普通话 (香港)']
 *                    ['cmn-Hant-TW', '中文 (台灣)']
 *                    ['yue-Hant-HK', '粵語 (香港)']
 *  日本語                         ['ja-JP']
 *  Lingua latīna     ['la']
 */
	voice_command_lang = 'en-US',
/*
 * 	Use localstorage to remember on/off (best used with HTML Version
 * 	when going from one page to the next)
 */	
	voice_localStorage = true;
/*
 * Voice Commands
 * Defines voice command variables and functions
 */	
 	if (voice_command) {
	 		
		var commands = {
					
			'show dashboard' : function() { $('nav a[href="dashboard.html"]').trigger("click"); },
			'show inbox' : function() { $('nav a[href="inbox.html"]').trigger("click"); },
			'show graphs' : function() { $('nav a[href="flot.html"]').trigger("click"); },
			'show flotchart' : function() { $('nav a[href="flot.html"]').trigger("click"); },
			'show morris chart' : function() { $('nav a[href="morris.html"]').trigger("click"); },
			'show inline chart' : function() { $('nav a[href="inline-charts.html"]').trigger("click"); },
			'show dygraphs' : function() { $('nav a[href="dygraphs.html"]').trigger("click"); },
			'show tables' : function() { $('nav a[href="table.html"]').trigger("click"); },
			'show data table' : function() { $('nav a[href="datatables.html"]').trigger("click"); },
			'show jquery grid' : function() { $('nav a[href="jqgrid.html"]').trigger("click"); },
			'show form' : function() { $('nav a[href="form-elements.html"]').trigger("click"); },
			'show form layouts' : function() { $('nav a[href="form-templates.html"]').trigger("click"); },
			'show form validation' : function() { $('nav a[href="validation.html"]').trigger("click"); },
			'show form elements' : function() { $('nav a[href="bootstrap-forms.html"]').trigger("click"); },
			'show form plugins' : function() { $('nav a[href="plugins.html"]').trigger("click"); },
			'show form wizards' : function() { $('nav a[href="wizards.html"]').trigger("click"); },
			'show bootstrap editor' : function() { $('nav a[href="other-editors.html"]').trigger("click"); },
			'show dropzone' : function() { $('nav a[href="dropzone.html"]').trigger("click"); },
			'show image cropping' : function() { $('nav a[href="image-editor.html"]').trigger("click"); },
			'show general elements' : function() { $('nav a[href="general-elements.html"]').trigger("click"); },
			'show buttons' : function() { $('nav a[href="buttons.html"]').trigger("click"); },
			'show fontawesome' : function() { $('nav a[href="fa.html"]').trigger("click"); },
			'show glyph icons' : function() { $('nav a[href="glyph.html"]').trigger("click"); },
			'show flags' : function() { $('nav a[href="flags.html"]').trigger("click"); },
			'show grid' : function() { $('nav a[href="grid.html"]').trigger("click"); },
			'show tree view' : function() { $('nav a[href="treeview.html"]').trigger("click"); },
			'show nestable lists' : function() { $('nav a[href="nestable-list.html"]').trigger("click"); },
			'show jquery U I' : function() { $('nav a[href="jqui.html"]').trigger("click"); },
			'show typography' : function() { $('nav a[href="typography.html"]').trigger("click"); },
			'show calendar' : function() { $('nav a[href="calendar.html"]').trigger("click"); },
			'show widgets' : function() { $('nav a[href="widgets.html"]').trigger("click"); },
			'show gallery' : function() { $('nav a[href="gallery.html"]').trigger("click"); },
			'show maps' : function() { $('nav a[href="gmap-xml.html"]').trigger("click"); },
			'show pricing tables' : function() { $('nav a[href="pricing-table.html"]').trigger("click"); },
			'show invoice' : function() { $('nav a[href="invoice.html"]').trigger("click"); },
			'show search' : function() { $('nav a[href="search.html"]').trigger("click"); },
			'go back' :  function() { history.back(1); }, 
			'scroll up' : function () { $('html, body').animate({ scrollTop: 0 }, 100); },
			'scroll down' : function () { $('html, body').animate({ scrollTop: $(document).height() }, 100);},
			'hide navigation' : function() { 
				if ($.root_.hasClass("container") && !$.root_.hasClass("menu-on-top")){
					$('span.minifyme').trigger("click");
				} else {
					$('#hide-menu > span > a').trigger("click"); 
				}
			},
			'show navigation' : function() { 
				if ($.root_.hasClass("container") && !$.root_.hasClass("menu-on-top")){
					$('span.minifyme').trigger("click");
				} else {
					$('#hide-menu > span > a').trigger("click"); 
				}
			},
			'mute' : function() {
				$.sound_on = false;
				$.smallBox({
					title : "MUTE",
					content : "All sounds have been muted!",
					color : "#a90329",
					timeout: 4000,
					icon : "fa fa-volume-off"
				});
			},
			'sound on' : function() {
				$.sound_on = true;
				$.speechApp.playConfirmation();
				$.smallBox({
					title : "UNMUTE",
					content : "All sounds have been turned on!",
					color : "#40ac2b",
					sound_file: 'voice_alert',
					timeout: 5000,
					icon : "fa fa-volume-up"
				});
			},
			'stop' : function() {
				smartSpeechRecognition.abort();
				$.root_.removeClass("voice-command-active");
				$.smallBox({
					title : "VOICE COMMAND OFF",
					content : "Your voice commands has been successfully turned off. Click on the <i class='fa fa-microphone fa-lg fa-fw'></i> icon to turn it back on.",
					color : "#40ac2b",
					sound_file: 'voice_off',
					timeout: 8000,
					icon : "fa fa-microphone-slash"
				});
				if ($('#speech-btn .popover').is(':visible')) {
					$('#speech-btn .popover').fadeOut(250);
				}
			},
			'help' : function() {
				$('#voiceModal').removeData('modal').modal( { remote: "ajax/modal-content/modal-voicecommand.html", show: true } );
				if ($('#speech-btn .popover').is(':visible')) {
					$('#speech-btn .popover').fadeOut(250);
				}
			},		
			'got it' : function() {
				$('#voiceModal').modal('hide');
			},	
			'logout' : function() {
				$.speechApp.stop();
				window.location = $('#logout > span > a').attr("href");
			}
		}; 
		
	};
/*
 * END APP.CONFIG
 */ 	
/*
 Copyright 2015 - SmartAdmin Template
 
 This script is a modified version of : MetroNotification
 Plugin name was adjusted with the permission of its author to blend in with the theme
 Original URL: http://codecanyon.net/item/metro-notifications/3903495

 * ************************************************************* */

jQuery(document).ready(function () {

    // Plugins placing
    $("body").append("<div id='divSmallBoxes'></div>");
    $("body").append("<div id='divMiniIcons'></div><div id='divbigBoxes'></div>");

});

//Closing Rutine for Loadings
function SmartUnLoading() {

    $(".divMessageBox").fadeOut(300, function () {
        $(this).remove();
    });

    $(".LoadingBoxContainer").fadeOut(300, function () {
        $(this).remove();
    });
}

// Messagebox
var ExistMsg = 0,
    SmartMSGboxCount = 0,
    PrevTop = 0;

    $.SmartMessageBox = function (settings, callback) {
        var SmartMSG, Content;
        settings = $.extend({
            title: "",
            content: "",
            NormalButton: undefined,
            ActiveButton: undefined,
            buttons: undefined,
            input: undefined,
            inputValue: undefined,
            placeholder: "",
            options: undefined
        }, settings);

        var PlaySound = 0;

        PlaySound = 1;
        //Messagebox Sound

        // SmallBox Sound
        if (isIE8orlower() == 0 && $.sound_on) {
            var audioElement = document.createElement('audio');
            audioElement.setAttribute('src', $.sound_path + 'messagebox.mp3');
            //$.get();
            audioElement.addEventListener("load", function () {
                audioElement.play();
            }, true);
			
			audioElement.pause();
        	audioElement.play();

        }

        SmartMSGboxCount = SmartMSGboxCount + 1;

        if (ExistMsg == 0) {
            ExistMsg = 1;
            SmartMSG = "<div class='divMessageBox animated fadeIn fast' id='MsgBoxBack'></div>";
            $("body").append(SmartMSG);

            if (isIE8orlower() == 1) {
                $("#MsgBoxBack").addClass("MessageIE");
            }
        }

        var InputType = "";
        var HasInput = 0;
        if (settings.input != undefined) {
            HasInput = 1;
            settings.input = settings.input.toLowerCase();

            switch (settings.input) {
            case "text":
                settings.inputValue = $.type(settings.inputValue) === 'string' ? settings.inputValue.replace(/'/g, "&#x27;") : settings.inputValue;
                InputType = "<input class='form-control' type='" + settings.input + "' id='txt" +
                    SmartMSGboxCount + "' placeholder='" + settings.placeholder + "' value='" + settings.inputValue + "'/><br/><br/>";
                break;
            case "password":
                InputType = "<input class='form-control' type='" + settings.input + "' id='txt" +
                    SmartMSGboxCount + "' placeholder='" + settings.placeholder + "'/><br/><br/>";
                break;

            case "select":
                if (settings.options == undefined) {
                    alert("For this type of input, the options parameter is required.");
                } else {
                    InputType = "<select class='form-control' id='txt" + SmartMSGboxCount + "'>";
                    for (var i = 0; i <= settings.options.length - 1; i++) {
                        if (settings.options[i] == "[") {
                            Name = "";
                        } else {
                            if (settings.options[i] == "]") {
                                NumBottons = NumBottons + 1;
                                Name = "<option>" + Name + "</option>";
                                InputType += Name;
                            } else {
                                Name += settings.options[i];
                            }
                        }
                    };
                    InputType += "</select>"
                }

                break;
            default:
                alert("That type of input is not handled yet");
            }

        }

        Content = "<div class='MessageBoxContainer animated fadeIn fast' id='Msg" + SmartMSGboxCount +
            "'>";
        Content += "<div class='MessageBoxMiddle'>";
        Content += "<span class='MsgTitle'>" + settings.title + "</span class='MsgTitle'>";
        Content += "<p class='pText'>" + settings.content + "</p>";
        Content += InputType;
        Content += "<div class='MessageBoxButtonSection'>";

        if (settings.buttons == undefined) {
            settings.buttons = "[Accept]";
        }

        settings.buttons = $.trim(settings.buttons);
        settings.buttons = settings.buttons.split('');

        var Name = "";
        var NumBottons = 0;
        if (settings.NormalButton == undefined) {
            settings.NormalButton = "#232323";
        }

        if (settings.ActiveButton == undefined) {
            settings.ActiveButton = "#ed145b";
        }

        for (var i = 0; i <= settings.buttons.length - 1; i++) {

            if (settings.buttons[i] == "[") {
                Name = "";
            } else {
                if (settings.buttons[i] == "]") {
                    NumBottons = NumBottons + 1;
                    Name = "<button id='bot" + NumBottons + "-Msg" + SmartMSGboxCount +
                        "' class='btn btn-light btn-sm botTempo'> " + Name + "</button>";
                    Content += Name;
                } else {
                    Name += settings.buttons[i];
                }
            }
        };

        Content += "</div>";
        //MessageBoxButtonSection
        Content += "</div>";
        //MessageBoxMiddle
        Content += "</div>";
        //MessageBoxContainer

        // alert(SmartMSGboxCount);
        if (SmartMSGboxCount > 1) {
            $(".MessageBoxContainer").hide();
            $(".MessageBoxContainer").css("z-index", 99999);
        }

        $(".divMessageBox").append(Content);

        // Focus
        if (HasInput == 1) {
            $("#txt" + SmartMSGboxCount).focus();
        }

        $('.botTempo').hover(function () {
            var ThisID = $(this).attr('id');
            // alert(ThisID);
            // $("#"+ThisID).css("background-color", settings.ActiveButton);
        }, function () {
            var ThisID = $(this).attr('id');
            //$("#"+ThisID).css("background-color", settings.NormalButton);
        });

        // Callback and button Pressed
        $(".botTempo").click(function () {
            // Closing Method
            var ThisID = $(this).attr('id');
            var MsgBoxID = ThisID.substr(ThisID.indexOf("-") + 1);
            var Press = $.trim($(this).text());

            if (HasInput == 1) {
                if (typeof callback == "function") {
                    var IDNumber = MsgBoxID.replace("Msg", "");
                    var Value = $("#txt" + IDNumber).val();
                    if (callback)
                        callback(Press, Value);
                }
            } else {
                if (typeof callback == "function") {
                    if (callback)
                        callback(Press);
                }
            }

            $("#" + MsgBoxID).addClass("animated fadeOut fast");
            SmartMSGboxCount = (SmartMSGboxCount) ? SmartMSGboxCount - 1 : 0;

            if (SmartMSGboxCount == 0) {
                $("#MsgBoxBack").removeClass("fadeIn").addClass("fadeOut").delay(300).queue(function () {
                    ExistMsg = 0;
                    $(this).remove();
                });
            }
        });

    }


// BigBox
var BigBoxes = 0;


    $.bigBox = function (settings, callback) {
        var boxBig, content;
        settings = $.extend({
            title: "",
            content: "",
            icon: undefined,
            number: undefined,
            color: undefined,
            sound: $.sound_on,
            sound_file: 'bigbox',
            timeout: undefined,
            colortime: 1500,
            colors: undefined
        }, settings);

        // bigbox Sound
        if (settings.sound) {
            if (isIE8orlower() == 0) {
                var audioElement = document.createElement('audio');

                if (navigator.userAgent.match('Firefox/'))
                    audioElement.setAttribute('src', $.sound_path + settings.sound_file + ".ogg");
                else
                    audioElement.setAttribute('src', $.sound_path + settings.sound_file + ".mp3");

                //$.get();
                audioElement.addEventListener("load", function () {
                    audioElement.play();
                }, true);

				audioElement.pause();
            	audioElement.play();

            }
        }

        BigBoxes = BigBoxes + 1;

        boxBig = "<div id='bigBox" + BigBoxes +
            "' class='bigBox animated fadeIn fast'><div id='bigBoxColor" + BigBoxes +
            "'><i class='botClose fa fa-times' id='botClose" + BigBoxes + "'></i>";
        boxBig += "<span>" + settings.title + "</span>";
        boxBig += "<p>" + settings.content + "</p>";
        boxBig += "<div class='bigboxicon'>";

        if (settings.icon == undefined) {
            settings.icon = "fa fa-cloud";
        }
        boxBig += "<i class='" + settings.icon + "'></i>";
        boxBig += "</div>";

        boxBig += "<div class='bigboxnumber'>";
        if (settings.number != undefined) {
            boxBig += settings.number;
        }

        boxBig += "</div></div>";
        boxBig += "</div>";

        // stacking method
        $("#divbigBoxes").append(boxBig);

        if (settings.color == undefined) {
            settings.color = "#004d60";
        }

        $("#bigBox" + BigBoxes).css("background-color", settings.color);

        $("#divMiniIcons").append("<div id='miniIcon" + BigBoxes +
            "' class='cajita animated fadeIn' style='background-color: " + settings.color +
            ";'><i class='" + settings.icon + "'/></i></div>");

        //Click Mini Icon
        $("#miniIcon" + BigBoxes).bind('click', function () {
            var FrontBox = $(this).attr('id');
            var FrontBigBox = FrontBox.replace("miniIcon", "bigBox");
            var FronBigBoxColor = FrontBox.replace("miniIcon", "bigBoxColor");

            $(".cajita").each(function (index) {
                var BackBox = $(this).attr('id');
                var BigBoxID = BackBox.replace("miniIcon", "bigBox");

                $("#" + BigBoxID).css("z-index", 9998);
            });

            $("#" + FrontBigBox).css("z-index", 9999);
            $("#" + FronBigBoxColor).removeClass("animated fadeIn").delay(1).queue(function () {
                $(this).show();
                $(this).addClass("animated fadeIn");
                $(this).clearQueue();

            });

        });

        var ThisBigBoxCloseCross = $("#botClose" + BigBoxes);
        var ThisBigBox = $("#bigBox" + BigBoxes);
        var ThisMiniIcon = $("#miniIcon" + BigBoxes);

        // Color Functionality
        var ColorTimeInterval;
        if (settings.colors != undefined && settings.colors.length > 0) {
            ThisBigBoxCloseCross.attr("colorcount", "0");

            ColorTimeInterval = setInterval(function () {

                var ColorIndex = ThisBigBoxCloseCross.attr("colorcount");

                ThisBigBoxCloseCross.animate({
                    backgroundColor: settings.colors[ColorIndex].color,
                });

                ThisBigBox.animate({
                    backgroundColor: settings.colors[ColorIndex].color,
                });

                ThisMiniIcon.animate({
                    backgroundColor: settings.colors[ColorIndex].color,
                });

                if (ColorIndex < settings.colors.length - 1) {
                    ThisBigBoxCloseCross.attr("colorcount", ((ColorIndex * 1) + 1));
                } else {
                    ThisBigBoxCloseCross.attr("colorcount", 0);
                }

            }, settings.colortime);
        }

        //Close Cross
        ThisBigBoxCloseCross.bind('click', function () {
            clearInterval(ColorTimeInterval);
            if (typeof callback == "function") {
                if (callback)
                    callback();
            }

            var FrontBox = $(this).attr('id');
            var FrontBigBox = FrontBox.replace("botClose", "bigBox");
            var miniIcon = FrontBox.replace("botClose", "miniIcon");

            $("#" + FrontBigBox).removeClass("fadeIn fast");
            $("#" + FrontBigBox).addClass("fadeOut fast").delay(300).queue(function () {
                $(this).clearQueue();
                $(this).remove();
            });

            $("#" + miniIcon).removeClass("fadeIn fast");
            $("#" + miniIcon).addClass("fadeOut fast").delay(300).queue(function () {
                $(this).clearQueue();
                $(this).remove();
            });

        });

        if (settings.timeout != undefined) {
            var TimedID = BigBoxes;
            setTimeout(function () {
                clearInterval(ColorTimeInterval);
                $("#bigBox" + TimedID).removeClass("fadeIn fast");
                $("#bigBox" + TimedID).addClass("fadeOut fast").delay(300).queue(function () {
                    $(this).clearQueue();
                    $(this).remove();
                });

                $("#miniIcon" + TimedID).removeClass("fadeIn fast");
                $("#miniIcon" + TimedID).addClass("fadeOut fast").delay(300).queue(function () {
                    $(this).clearQueue();
                    $(this).remove();
                });

            }, settings.timeout);
        }

    }


// .BigBox

// Small Notification
var SmallBoxes = 0,
    SmallCount = 0,
    SmallBoxesAnchos = 0;


    $.smallBox = function (settings, callback) {
        var BoxSmall, content;
        settings = $.extend({
            title: "",
            content: "",
            icon: undefined,
            iconSmall: undefined,
            sound: $.sound_on,
            sound_file: 'smallbox',
            color: undefined,
            timeout: undefined,
            colortime: 1500,
            colors: undefined
        }, settings);

        // SmallBox Sound
        if (settings.sound) {
            if (isIE8orlower() == 0) {
                var audioElement = document.createElement('audio');

                if (navigator.userAgent.match('Firefox/'))
                    audioElement.setAttribute('src', $.sound_path + settings.sound_file + ".ogg");
                else
                    audioElement.setAttribute('src', $.sound_path + settings.sound_file + ".mp3");

                //$.get();
                audioElement.addEventListener("load", function () {
                    audioElement.play();
                }, true);

				audioElement.pause();
            	audioElement.play();

            }
        }

        SmallBoxes = SmallBoxes + 1;

        BoxSmall = ""

        var IconSection = "",
            CurrentIDSmallbox = "smallbox" + SmallBoxes;

        if (settings.iconSmall == undefined) {
            IconSection = "<div class='miniIcono'></div>";
        } else {
            IconSection = "<div class='miniIcono'><i class='miniPic " + settings.iconSmall +
                "'></i></div>";
        }

        if (settings.icon == undefined) {
            BoxSmall = "<div id='smallbox" + SmallBoxes +
                "' class='SmallBox animated fadeInRight fast'><div class='textoFull'><span>" + settings.title +
                "</span><p>" + settings.content + "</p></div>" + IconSection + "</div>";
        } else {
            BoxSmall = "<div id='smallbox" + SmallBoxes +
                "' class='SmallBox animated fadeInRight fast'><div class='foto'><i class='" + settings.icon +
                "'></i></div><div class='textoFoto'><span>" + settings.title + "</span><p>" + settings.content +
                "</p></div>" + IconSection + "</div>";
        }

        if (SmallBoxes == 1) {
            $("#divSmallBoxes").append(BoxSmall);
            SmallBoxesAnchos = $("#smallbox" + SmallBoxes).height() + 40;
        } else {
            var SmartExist = $(".SmallBox").length;
            if (SmartExist == 0) {
                $("#divSmallBoxes").append(BoxSmall);
                SmallBoxesAnchos = $("#smallbox" + SmallBoxes).height() + 40;
            } else {
                $("#divSmallBoxes").append(BoxSmall);
                $("#smallbox" + SmallBoxes).css("top", SmallBoxesAnchos);
                SmallBoxesAnchos = SmallBoxesAnchos + $("#smallbox" + SmallBoxes).height() + 20;

                $(".SmallBox").each(function (index) {

                    if (index == 0) {
                        $(this).css("top", 20);
                        heightPrev = $(this).height() + 40;
                        SmallBoxesAnchos = $(this).height() + 40;
                    } else {
                        $(this).css("top", heightPrev);
                        heightPrev = heightPrev + $(this).height() + 20;
                        SmallBoxesAnchos = SmallBoxesAnchos + $(this).height() + 20;
                    }

                });

            }
        }

        var ThisSmallBox = $("#smallbox" + SmallBoxes);

        // IE fix
        // if($.browser.msie) {
        //     // alert($("#"+CurrentIDSmallbox).css("height"));
        // }

        if (settings.color == undefined) {
            ThisSmallBox.css("background-color", "#004d60");
        } else {
            ThisSmallBox.css("background-color", settings.color);
        }

        var ColorTimeInterval;

        if (settings.colors != undefined && settings.colors.length > 0) {
            ThisSmallBox.attr("colorcount", "0");

            ColorTimeInterval = setInterval(function () {

                var ColorIndex = ThisSmallBox.attr("colorcount");

                ThisSmallBox.animate({
                    backgroundColor: settings.colors[ColorIndex].color,
                });

                if (ColorIndex < settings.colors.length - 1) {
                    ThisSmallBox.attr("colorcount", ((ColorIndex * 1) + 1));
                } else {
                    ThisSmallBox.attr("colorcount", 0);
                }

            }, settings.colortime);
        }

        if (settings.timeout != undefined) {

            setTimeout(function () {
                clearInterval(ColorTimeInterval);
                var ThisHeight = $(this).height() + 20;
                var ID = CurrentIDSmallbox;
                var ThisTop = $("#" + CurrentIDSmallbox).css('top');

                // SmallBoxesAnchos = SmallBoxesAnchos - ThisHeight;
                // $("#"+CurrentIDSmallbox).remove();

                if ($("#" + CurrentIDSmallbox + ":hover").length != 0) {
                    //Mouse Over the element
                    $("#" + CurrentIDSmallbox).on("mouseleave", function () {
                        SmallBoxesAnchos = SmallBoxesAnchos - ThisHeight;
                        $("#" + CurrentIDSmallbox).remove();
                        if (typeof callback == "function") {
                            if (callback)
                                callback();
                        }

                        var Primero = 1;
                        var heightPrev = 0;
                        $(".SmallBox").each(function (index) {

                            if (index == 0) {
                                $(this).animate({
                                    top: 20
                                }, 300);

                                heightPrev = $(this).height() + 40;
                                SmallBoxesAnchos = $(this).height() + 40;
                            } else {
                                $(this).animate({
                                    top: heightPrev
                                }, 350);

                                heightPrev = heightPrev + $(this).height() + 20;
                                SmallBoxesAnchos = SmallBoxesAnchos + $(this).height() + 20;
                            }

                        });
                    });
                } else {
                    clearInterval(ColorTimeInterval);
                    SmallBoxesAnchos = SmallBoxesAnchos - ThisHeight;

                    if (typeof callback == "function") {
                        if (callback)
                            callback();
                    }

                    $("#" + CurrentIDSmallbox).removeClass().addClass("SmallBox").animate({
                        opacity: 0
                    }, 300, function () {

                        $(this).remove();

                        var Primero = 1;
                        var heightPrev = 0;
                        $(".SmallBox").each(function (index) {

                            if (index == 0) {
                                $(this).animate({
                                    top: 20
                                }, 300);

                                heightPrev = $(this).height() + 40;
                                SmallBoxesAnchos = $(this).height() + 40;
                            } else {
                                $(this).animate({
                                    top: heightPrev
                                });

                                heightPrev = heightPrev + $(this).height() + 20;
                                SmallBoxesAnchos = SmallBoxesAnchos + $(this).height() + 20;
                            }

                        });
                    })
                }

            }, settings.timeout);
        }

        // Click Closing
        $("#smallbox" + SmallBoxes).bind('click', function () {
            clearInterval(ColorTimeInterval);
            if (typeof callback == "function") {
                if (callback)
                    callback();
            }

            var ThisHeight = $(this).height() + 20;
            var ID = $(this).attr('id');
            var ThisTop = $(this).css('top');

            SmallBoxesAnchos = SmallBoxesAnchos - ThisHeight;

            $(this).removeClass().addClass("SmallBox").animate({
                opacity: 0
            }, 300, function () {
                $(this).remove();

                var Primero = 1;
                var heightPrev = 0;

                $(".SmallBox").each(function (index) {

                    if (index == 0) {
                        $(this).animate({
                            top: 20,
                        }, 300);
                        heightPrev = $(this).height() + 40;
                        SmallBoxesAnchos = $(this).height() + 40;
                    } else {
                        $(this).animate({
                            top: heightPrev
                        }, 350);
                        heightPrev = heightPrev + $(this).height() + 20;
                        SmallBoxesAnchos = SmallBoxesAnchos + $(this).height() + 20;
                    }

                });
            })
        });

    }


// .Small Notification

// Sounds

function getInternetExplorerVersion() {
    var rv = -1;
    // Return value assumes failure.
    if (navigator.appName == 'Microsoft Internet Explorer') {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat(RegExp.$1);
    }
    return rv;
}

function checkVersion() {

    var msg = "You're not using Windows Internet Explorer.";
    var ver = getInternetExplorerVersion();
    if (ver > -1) {
        if (ver >= 8.0)
            msg = "You're using a recent copy of Windows Internet Explorer."
        else
            msg = "You should upgrade your copy of Windows Internet Explorer.";
    }
    alert(msg);

}

function isIE8orlower() {

    var msg = "0";
    var ver = getInternetExplorerVersion();
    if (ver > -1) {
        if (ver >= 9.0)
            msg = 0
        else
            msg = 1;
    }
    return msg;
    // alert(msg);
}

/*
 * =======================================================================
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * =======================================================================
 * original filename: jarvis.widget.js
 * filesize: 56.7 KB (58,158 bytes)
 */

(function ($, window, document, undefined) {

    //"use strict"; 

    var pluginName = 'jarvisWidgets';

	/**
	 * Check for touch support and set right click events.
	 **/
	var clickEvent = (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch ? 
		'clickEvent' : 'click') + '.' + pluginName;

    function Plugin(element, options) {
        /**
         * Variables.
         **/
        this.obj = $(element);
        this.o = $.extend({}, $.fn[pluginName].defaults, options);
        this.objId = this.obj.attr('id');
        this.pwCtrls = '.jarviswidget-ctrls';
        this.widget = this.obj.find(this.o.widgets);
        this.toggleClass = this.o.toggleClass.split('|');
        this.editClass = this.o.editClass.split('|');
        this.fullscreenClass = this.o.fullscreenClass.split('|');
        this.customClass = this.o.customClass.split('|');
		this.storage = {enabled: this.o.localStorage};
		this.initialized = false;

        this.init();
    }

    Plugin.prototype = {

        /**
         * Function for the indicator image.
         *
         * @param:
         **/
        _runLoaderWidget: function (elm) {
            var self = this;
            if (self.o.indicator === true) {
                elm.parents(self.o.widgets)
                    .find('.jarviswidget-loader:first')
                    .stop(true, true)
                    .fadeIn(100)
                    .delay(self.o.indicatorTime)
                    .fadeOut(100);
            }
        },

        /**
         * Create a fixed timestamp.
         *
         * @param: t | date | Current date.
         **/
        _getPastTimestamp: function (t) {

            var self = this;

            var da = new Date(t);
            

            /**
             * Get and set the date and time.
             **/
            var tsMonth = da.getMonth() + 1;
            // index based
            var tsDay = da.getDate();
            var tsYear = da.getFullYear();
            var tsHours = da.getHours();
            var tsMinutes = da.getMinutes();
            var tsSeconds = da.getUTCSeconds();

            /**
             * Checking for one digit values, if so add an zero.
             **/
            if (tsMonth < 10) {
                tsMonth = '0' + tsMonth;
            }
            if (tsDay < 10) {
                tsDay = '0' + tsDay;
            }
            if (tsHours < 10) {
                tsHours = '0' + tsHours;
            }
            if (tsMinutes < 10) {
                tsMinutes = '0' + tsMinutes;
            }
            if (tsSeconds < 10) {
                tsSeconds = '0' + tsSeconds;
            }

            /**
             * The output, how you want it.
             **/
            var format = self.o.timestampFormat.replace(/%d%/g, tsDay)
                .replace(/%m%/g, tsMonth)
                .replace(/%y%/g, tsYear)
                .replace(/%h%/g, tsHours)
                .replace(/%i%/g, tsMinutes)
                .replace(/%s%/g, tsSeconds);

            return format;
        },

        /**
         * AJAX load File, which get and shows the .
         *
         * @param: awidget | object  | The widget.
         * @param: file    | file    | The file thats beeing loaded.
         * @param: loader  | object  | The widget.
         **/
        _loadAjaxFile: function (awidget, file, loader) {

            var self = this;

            awidget.find('.widget-body')
                .load(file, function (response, status, xhr) {

                    var $this = $(this);

                    /**
                     * If action runs into an error display an error msg.
                     **/
                    if (status == "error") {
                        $this.html('<h4 class="alert alert-danger">' + self.o.labelError + '<b> ' +
                            xhr.status + " " + xhr.statusText + '</b></h4>');
                    }

                    /**
                     * Run if there are no errors.
                     **/
                    if (status == "success") {

                        /**
                         * Show a timestamp.
                         **/
                        var aPalceholder = awidget.find(self.o.timestampPlaceholder);

                        if (aPalceholder.length) {

                            aPalceholder.html(self._getPastTimestamp(new Date()));
                        }

                        /**
                         * Run the callback function.
                         **/
                        if (typeof self.o.afterLoad == 'function') {
                            self.o.afterLoad.call(this, awidget);
                        }
                    }

					self = null;
                });

            /**
             * Run function for the indicator image.
             **/
            this._runLoaderWidget(loader);

        },

		_loadKeys : function () {
			
			var self = this;

			//*****************************************************************//
            /////////////////////////// SET/GET KEYS ////////////////////////////
            //*****************************************************************//

            // TODO : Push state does not work on IE9, try to find a way to detect IE and use a seperate filter

			if (self.o.ajaxnav === true) {
				var widget_url = location.hash.replace(/^#/, '');
				self.storage.keySettings = 'Plugin_settings_' + widget_url + '_' + self.objId;
				self.storage.keyPosition = 'Plugin_position_' + widget_url + '_' + self.objId;
			} else if (self.initialized === false) {
				var widget_url = self.o.pageKey || location.pathname;
				self.storage.keySettings = 'jarvisWidgets_settings_' + widget_url + '_' + self.objId;
				self.storage.keyPosition = 'jarvisWidgets_position_' + widget_url + '_' + self.objId;
			}

		},
 
        /**
         * Save all settings to the localStorage.
         *
         * @param:
         **/
        _saveSettingsWidget: function () {

            var self = this;
			var storage = self.storage;

			self._loadKeys();

			var storeSettings = self.obj.find(self.o.widgets)
				.map(function () {
					var storeSettingsStr = {};
					storeSettingsStr.id = $(this)
						.attr('id');
					storeSettingsStr.style = $(this)
						.attr('data-widget-attstyle');
					storeSettingsStr.title = $(this)
						.children('header')
						.children().first().children('h2')
						.text();
					storeSettingsStr.hidden = ($(this)
						.css('display') == 'none' ? 1 : 0);
					storeSettingsStr.collapsed = ($(this)
						.hasClass('jarviswidget-collapsed') ? 1 : 0);
					return storeSettingsStr;
				}).get();

			var storeSettingsObj = JSON.stringify({
				'widget': storeSettings
			});

			/* Place it in the storage(only if needed) */
			if (storage.enabled && storage.getKeySettings != storeSettingsObj) {
				localStorage.setItem(storage.keySettings, storeSettingsObj);
				storage.getKeySettings = storeSettingsObj;
			}

            /**
             * Run the callback function.
             **/
            
            if (typeof self.o.onSave == 'function') {
                self.o.onSave.call(this, null, storeSettingsObj, storage.keySettings);
            }
        },

        /**
         * Save positions to the localStorage.
         *
         * @param:
         **/
        _savePositionWidget: function () {

            var self = this;
			var storage = self.storage;

			self._loadKeys();

			var mainArr = self.obj.find(self.o.grid + '.sortable-grid')
				.map(function () {
					var subArr = $(this)
						.children(self.o.widgets)
						.map(function () {
							return {
								'id': $(this).attr('id')
							};
						}).get();
					return {
						'section': subArr
					};
				}).get();

			var storePositionObj = JSON.stringify({
				'grid': mainArr
			});

			/* Place it in the storage(only if needed) */
			if (storage.enabled && storage.getKeyPosition != storePositionObj) {
				localStorage.setItem(storage.keyPosition, storePositionObj);
				storage.getKeyPosition = storePositionObj
			}

            /**
             * Run the callback function.
             **/
            if (typeof self.o.onSave == 'function') {
                self.o.onSave.call(this, storePositionObj, storage.keyPosition);
            }
        },

        /**
         * Code that we run at the start.
         *
         * @param:
         **/
        init: function () {

            var self = this;
			
			if (self.initialized) return;

            self._initStorage(self.storage);

            /**
             * Force users to use an id(it's needed for the local storage).
             **/
            if (!$('#' + self.objId)
                .length) {
                alert('It looks like your using a class instead of an ID, dont do that!');
            }

            /**
             * Add RTL support.
             **/
            if (self.o.rtl === true) {
                $('body')
                    .addClass('rtl');
            }

            /**
             * This will add an extra class that we use to store the
             * widgets in the right order.(savety)
             **/

            $(self.o.grid)
                .each(function () {
                    if ($(this)
                        .find(self.o.widgets)
                        .length) {
                        $(this)
                            .addClass('sortable-grid');
                    }
                });

            //*****************************************************************//
            //////////////////////// SET POSITION WIDGET ////////////////////////
            //*****************************************************************//

            /**
             * Run if data is present.
             **/
            if (self.storage.enabled && self.storage.getKeyPosition) {

                var jsonPosition = JSON.parse(self.storage.getKeyPosition);

                /**
                 * Loop the data, and put every widget on the right place.
                 **/
                for (var key in jsonPosition.grid) {
                    var changeOrder = self.obj.find(self.o.grid + '.sortable-grid')
                        .eq(key);
                    for (var key2 in jsonPosition.grid[key].section) {
                        changeOrder.append($('#' + jsonPosition.grid[key].section[key2].id));
                    }
                }

            }

            //*****************************************************************//
            /////////////////////// SET SETTINGS WIDGET /////////////////////////
            //*****************************************************************//

            /**
             * Run if data is present.
             **/
            if (self.storage.enabled && self.storage.getKeySettings) {

                var jsonSettings = JSON.parse(self.storage.getKeySettings);

                /**
                 * Loop the data and hide/show the widgets and set the inputs in
                 * panel to checked(if hidden) and add an indicator class to the div.
                 * Loop all labels and update the widget titles.
                 **/
                for (var key in jsonSettings.widget) {
                    var widgetId = $('#' + jsonSettings.widget[key].id);

                    /**
                     * Set a style(if present).
                     **/
                    if (jsonSettings.widget[key].style) {
                        //console.log("test");
                        widgetId.removeClassPrefix('jarviswidget-color-')
                            .addClass(jsonSettings.widget[key].style)
                            .attr('data-widget-attstyle', '' + jsonSettings.widget[key].style + '');
                    }

                    /**
                     * Hide/show widget.
                     **/
                    if (jsonSettings.widget[key].hidden == 1) {
                        widgetId.hide(1);
                    } else {
                        widgetId.show(1)
                            .removeAttr('data-widget-hidden');
                    }

                    /**
                     * Toggle content widget.
                     **/
                    if (jsonSettings.widget[key].collapsed == 1) {
                        widgetId.addClass('jarviswidget-collapsed')
                            .children('div')
                            .hide(1);
                    }

                    /**
                     * Update title widget (if needed).
                     **/
                    if (widgetId.children('header')
                        .children('.widget-header')
                        .children('h2')
                        .text() != jsonSettings.widget[key].title) {
                        widgetId.children('header')
                            .children('.widget-header')
                            .children('h2')
                            .text(jsonSettings.widget[key].title);
                    }
                }
            }

            //*****************************************************************//
            ////////////////////////// LOOP AL WIDGETS //////////////////////////
            //*****************************************************************//

            /**
             * This will add/edit/remove the settings to all widgets
             **/
            self.widget.each(function () {

                var tWidget = $(this),
                	thisHeader = $(this).children('header'),
                	customBtn,
                	deleteBtn,  
                	editBtn,  
                	fullscreenBtn,
                	widgetcolorBtn,
                	toggleBtn,
                	toggleSettings,
                  	refreshBtn;

                /**
                 * Dont double wrap(check).
                 **/
                if (!thisHeader.parent()
                    .attr('role')) {

                    /**
                     * Hide the widget if the dataset 'widget-hidden' is set to true.
                     **/
                    if (tWidget.data('widget-hidden') === true) {

                        tWidget.hide();
                    }

                    /**
					 * Hide the content of the widget if the dataset
					 * 'widget-collapsed' is set to true.

					 **/
                    if (tWidget.data('widget-collapsed') === true) {
                        tWidget.addClass('jarviswidget-collapsed')
                            .children('div')
                            .hide();
                    }

                    /**
                     * Check for the dataset 'widget-icon' if so get the icon
                     * and attach it to the widget header.
                     * NOTE: MOVED THIS TO PHYSICAL for more control
                     **/
                    //if(tWidget.data('widget-icon')){
                    //	thisHeader.append('<i class="jarviswidget-icon '+tWidget.data('widget-icon')+'"></i>');
                    //}

                    /**
                     * Add a delete button to the widget header (if set to true).
                     **/
                    if (self.o.customButton === true && tWidget.data('widget-custombutton') ===
                        undefined && self.customClass[0].length !== 0) {
                        customBtn =
                            '<a href="javascript:void(0);" class="button-icon jarviswidget-custom-btn"><i class="' +
                            self.customClass[0] + '"></i></a>';
                    } else {
                        customBtn = '';
                    }

                    /**
                     * Add a delete button to the widget header (if set to true).
                     **/
                    if (self.o.deleteButton === true && tWidget.data('widget-deletebutton') ===
                        undefined) {
                        deleteBtn =
                            '<a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="Delete" data-placement="bottom"><i class="' +
                            self.o.deleteClass + '"></i></a>';
                    } else {
                        deleteBtn = '';
                    }

                    /**
                     * Add a delete button to the widget header (if set to true).
                     **/
                    if (self.o.editButton === true && tWidget.data('widget-editbutton') === undefined) {
                        editBtn =
                            '<a href="javascript:void(0);" class="button-icon jarviswidget-edit-btn" rel="tooltip" title="Edit" data-placement="bottom"><i class="' +
                            self.editClass[0] + '"></i></a>';
                    } else {
                        editBtn = '';
                    }

                    /**
                     * Add a delete button to the widget header (if set to true).
                     **/
                    if (self.o.fullscreenButton === true && tWidget.data('widget-fullscreenbutton') ===
                        undefined) {
                        fullscreenBtn =
                            '<a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="Fullscreen" data-placement="bottom"><i class="' +
                            self.fullscreenClass[0] + '"></i></a>';
                    } else {
                        fullscreenBtn = '';
                    }

                    /**
                     * Add a delete button to the widget header (if set to true).
                     **/
                    if (self.o.colorButton === true && tWidget.data('widget-colorbutton') ===
                        undefined) {
                        widgetcolorBtn =
                            '<a data-toggle="dropdown" class="dropdown-toggle color-box selector" href="javascript:void(0);"></a><ul class="dropdown-menu arrow-box-up-right color-select dropdown-menu-right"><li><span class="bg-green" data-widget-setstyle="jarviswidget-color-green" rel="tooltip" data-placement="left" data-original-title="Green Grass"></span></li><li><span class="bg-green-dark" data-widget-setstyle="jarviswidget-color-green-dark" rel="tooltip" data-placement="top" data-original-title="Dark Green"></span></li><li><span class="bg-green-light" data-widget-setstyle="jarviswidget-color-green-light" rel="tooltip" data-placement="top" data-original-title="Light Green"></span></li><li><span class="bg-purple" data-widget-setstyle="jarviswidget-color-purple" rel="tooltip" data-placement="top" data-original-title="Purple"></span></li><li><span class="bg-magenta" data-widget-setstyle="jarviswidget-color-magenta" rel="tooltip" data-placement="top" data-original-title="Magenta"></span></li><li><span class="bg-pink" data-widget-setstyle="jarviswidget-color-pink" rel="tooltip" data-placement="right" data-original-title="Pink"></span></li><li><span class="bg-pink-dark" data-widget-setstyle="jarviswidget-color-pink-dark" rel="tooltip" data-placement="left" data-original-title="Fade Pink"></span></li><li><span class="bg-blue-light" data-widget-setstyle="jarviswidget-color-blue-light" rel="tooltip" data-placement="top" data-original-title="Light Blue"></span></li><li><span class="bg-teal" data-widget-setstyle="jarviswidget-color-teal" rel="tooltip" data-placement="top" data-original-title="Teal"></span></li><li><span class="bg-blue" data-widget-setstyle="jarviswidget-color-blue" rel="tooltip" data-placement="top" data-original-title="Ocean Blue"></span></li><li><span class="bg-blue-dark" data-widget-setstyle="jarviswidget-color-blue-dark" rel="tooltip" data-placement="top" data-original-title="Night Sky"></span></li><li><span class="bg-darken" data-widget-setstyle="jarviswidget-color-darken" rel="tooltip" data-placement="right" data-original-title="Night"></span></li><li><span class="bg-yellow" data-widget-setstyle="jarviswidget-color-yellow" rel="tooltip" data-placement="left" data-original-title="Day Light"></span></li><li><span class="bg-orange" data-widget-setstyle="jarviswidget-color-orange" rel="tooltip" data-placement="bottom" data-original-title="Orange"></span></li><li><span class="bg-orange-dark" data-widget-setstyle="jarviswidget-color-orange-dark" rel="tooltip" data-placement="bottom" data-original-title="Dark Orange"></span></li><li><span class="bg-red" data-widget-setstyle="jarviswidget-color-red" rel="tooltip" data-placement="bottom" data-original-title="Red Rose"></span></li><li><span class="bg-red-light" data-widget-setstyle="jarviswidget-color-red-light" rel="tooltip" data-placement="bottom" data-original-title="Light Red"></span></li><li><span class="bg-white" data-widget-setstyle="jarviswidget-color-white" rel="tooltip" data-placement="right" data-original-title="Purity"></span></li><li><a href="javascript:void(0);" class="jarviswidget-remove-colors" data-widget-setstyle="" rel="tooltip" data-placement="bottom" data-original-title="Reset widget color to default">Remove</a></li></ul>';
                        thisHeader.append('<div class="widget-toolbar">' + widgetcolorBtn + '</div>');

                    } else {
                        widgetcolorBtn = '';
                    }

                    /**
                     * Add a toggle button to the widget header (if set to true).
                     **/
                    if (self.o.toggleButton === true && tWidget.data('widget-togglebutton') ===
                        undefined) {
                        if (tWidget.data('widget-collapsed') === true || tWidget.hasClass(
                            'jarviswidget-collapsed')) {
                            toggleSettings = self.toggleClass[1];
                        } else {
                            toggleSettings = self.toggleClass[0];
                        }
                        toggleBtn =
                            '<a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="Collapse" data-placement="bottom"><i class="' +
                            toggleSettings + '"></i></a>';
                    } else {
                        toggleBtn = '';
                    }

                    /**
                     * Add a refresh button to the widget header (if set to true).
                     **/
                    if (self.o.refreshButton === true && tWidget.data('widget-refreshbutton') !==
                        false && tWidget.data('widget-load')) {
                        refreshBtn =
                            '<a href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" data-loading-text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="Refresh" data-placement="bottom"><i class="' +
                            self.o.refreshButtonClass + '"></i></a>';
                    } else {
                        refreshBtn = '';
                    }

                    /**
                     * Set the buttons order.
                     **/
                    var formatButtons = self.o.buttonOrder.replace(/%refresh%/g, refreshBtn)
                        .replace(/%delete%/g, deleteBtn)
                        .replace(/%custom%/g, customBtn)
                        .replace(/%fullscreen%/g, fullscreenBtn)
                        .replace(/%edit%/g, editBtn)
                        .replace(/%toggle%/g, toggleBtn);

                    /**
                     * Add a button wrapper to the header.
                     **/
                    if (refreshBtn !== '' || deleteBtn !== '' || customBtn !== '' || fullscreenBtn !== '' ||
                        editBtn !== '' || toggleBtn !== '') {
                        thisHeader.append('<div class="jarviswidget-ctrls">' + formatButtons +
                            '</div>');
                    }

                    /**
                     * Adding a helper class to all sortable widgets, this will be
                     * used to find the widgets that are sortable, it will skip the widgets
                     * that have the dataset 'widget-sortable="false"' set to false.
                     **/
                    if (self.o.sortable === true && tWidget.data('widget-sortable') === undefined) {
                        tWidget.addClass('jarviswidget-sortable');
                    }

                    /**
                     * If the edit box is present copy the title to the input.
                     **/
                    if (tWidget.find(self.o.editPlaceholder)
                        .length) {
                        tWidget.find(self.o.editPlaceholder)
                            .find('input')
                            .val($.trim(thisHeader.children('.widget-header').children('h2')
                                .text()));
                    }

                    /**
                     * append the image to the widget header.
                     **/
                    thisHeader.children('.widget-header').after(
                        '<span class="ml-auto"></span><span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>'
                    );

                    /**
                     * Adding roles to some parts.
                     **/
                    tWidget.attr('role', 'widget')
                        .children('div')
                        .attr('role', 'content')
                        .prev('header')
                        .attr('role', 'heading')
                        .children('.widget-header')
                        .nextAll()
                        .attr('role', 'menu');
                }
            });

            /**
             * Hide all buttons if option is set to true.
             **/
            if (self.o.buttonsHidden === true) {
                $(self.o.pwCtrls)
                    .hide();
            }

            /* activate all tooltips */
            $(".jarviswidget header [rel=tooltip]")
                .tooltip();

            //******************************************************************//
            //////////////////////////////// AJAX ////////////////////////////////
            //******************************************************************//

            /**
             * Loop all ajax widgets.
             **/
            // $.intervalArr = new Array(); - decleared in app.js
            self.obj.find('[data-widget-load]')
                .each(function () {

                    /**
                     * Variables.
                     **/
                    var thisItem = $(this),
                        thisItemHeader = thisItem.children(),
                        pathToFile = thisItem.data('widget-load'),
                        reloadTime = thisItem.data('widget-refresh') * 1000,
                        ajaxLoader = thisItem.children();

                    if (!thisItem.find('.jarviswidget-ajax-placeholder')
                        .length) {

                        /**
                         * Append a AJAX placeholder.
                         **/
                        thisItem.children('widget-body')
                            .append('<div class="jarviswidget-ajax-placeholder">' + self.o.loadingLabel +
                                '</div>');

                        /**
                         * If widget has a reload time refresh the widget, if the value
                         * has been set to 0 dont reload.
                         **/
                        if (thisItem.data('widget-refresh') > 0) {

                            /**
                             * Load file on start.
                             **/
                            self._loadAjaxFile(thisItem, pathToFile, thisItemHeader);

                            /**
                             * Set an interval to reload the content every XXX seconds.
                             * intervalArr.push(setInterval(intervalOne, 2000)  );
                             **/
                            $.intervalArr.push( setInterval(function () {self._loadAjaxFile(thisItem, pathToFile, thisItemHeader)}, reloadTime) );
                            
                        } else {

                            /**
                             * Load the content just once.
                             **/
                            self._loadAjaxFile(thisItem, pathToFile, thisItemHeader);

                        }
                    }
                });

            //******************************************************************//
            ////////////////////////////// SORTABLE //////////////////////////////
            //******************************************************************//

            /**
             * jQuery UI soratble, this allows users to sort the widgets.
             * Notice that this part needs the jquery-ui core to work.
             **/
            if (self.o.sortable === true && jQuery.ui) {
                var sortItem = self.obj.find(self.o.grid + '.sortable-grid')
                    .not('[data-widget-excludegrid]');
                sortItem.sortable({
                    items: sortItem.find(self.o.widgets + '.jarviswidget-sortable'),
                    connectWith: sortItem,
                    placeholder: self.o.placeholderClass,
                    cursor: 'move',
                    revert: true,
                    opacity: self.o.opacity,
                    delay: 200,
                    cancel: '.button-icon, #jarviswidget-fullscreen-mode > div',
                    zIndex: 10000,
                    handle: self.o.dragHandle,
                    forcePlaceholderSize: true,
                    forceHelperSize: true,
                    update: function (event, ui) {
                        /* run pre-loader in the widget */
                        self._runLoaderWidget(ui.item.children());
                        /* store the positions of the plugins */
                        self._savePositionWidget();
                        /**
                         * Run the callback function.
                         **/
                        if (typeof self.o.onChange == 'function') {
                            self.o.onChange.call(this, ui.item);
                        }
                    }
                });
            }

            //*****************************************************************//
            ////////////////////////// BUTTONS VISIBLE //////////////////////////
            //*****************************************************************//

            /**
             * Show and hide the widget control buttons, the buttons will be
             * visible if the users hover over the widgets header. At default the
             * buttons are always visible.
             **/
            if (self.o.buttonsHidden === true) {

                /**
                 * Show and hide the buttons.
                 **/
                self.widget.children('header')
                    .on('mouseenter.' + pluginName, function () {
                        $(this)
                            .children(self.o.pwCtrls)
                            .stop(true, true)
                            .fadeTo(100, 1.0);
                    })
					.on('mouseleave.' + pluginName, function () {
                        $(this)
                            .children(self.o.pwCtrls)
                            .stop(true, true)
                            .fadeTo(100, 0.0);
                    });
            }

            //*****************************************************************//
            ///////////////////////// CLICKEVENTS //////////////////////////
            //*****************************************************************//

            self._clickEvents();

            //*****************************************************************//
            ///////////////////// DELETE LOCAL STORAGE KEYS /////////////////////
            //*****************************************************************//

			if (self.storage.enabled) {
				/**
				 * Delete the settings key.
				 **/
				$(self.o.deleteSettingsKey)
					.on(clickEvent, this, function (e) {
                        var cleared = confirm(self.o.settingsKeyLabel);
                        if (cleared) {
                            localStorage.removeItem(keySettings);
                        }
						e.preventDefault();
					});
				/**
				 * Delete the position key.
				 **/
				$(self.o.deletePositionKey)
					.on(clickEvent, this, function (e) {
                        var cleared = confirm(self.o.positionKeyLabel);
                        if (cleared) {
                            localStorage.removeItem(keyPosition);
                        }
						e.preventDefault();
					});
			}

			initialized = true;
        },

        /**
         * Initialize storage.
         *
         * @param:
         **/
        _initStorage: function (storage) {

            //*****************************************************************//
            //////////////////////// LOCALSTORAGE CHECK /////////////////////////
            //*****************************************************************//

            storage.enabled = storage.enabled && !! function () {
                var result, uid = +new Date();
                try {
                    localStorage.setItem(uid, uid);
                    result = localStorage.getItem(uid) == uid;
                    localStorage.removeItem(uid);
                    return result;
                } catch (e) {}
            }();

			this._loadKeys();

            if (storage.enabled) {

				storage.getKeySettings = localStorage.getItem(storage.keySettings);
				storage.getKeyPosition = localStorage.getItem(storage.keyPosition);
				
            } // end if

        },

        /**
         * All of the click events.
         *
         * @param:
         **/
        _clickEvents: function () {

            var self = this;

            var headers = self.widget.children('header');

            //*****************************************************************//
            /////////////////////////// TOGGLE WIDGETS //////////////////////////
            //*****************************************************************//

            /**
             * Allow users to toggle the content of the widgets.
             **/
            headers.on(clickEvent, '.jarviswidget-toggle-btn', function (e) {

                var tWidget = $(this);
                var pWidget = tWidget.parents(self.o.widgets);

                /**
                 * Run function for the indicator image.
                 **/
                self._runLoaderWidget(tWidget);

                /**
                 * Change the class and hide/show the widgets content.
                 **/
                if (pWidget.hasClass('jarviswidget-collapsed')) {
                    tWidget.children()
                        .removeClass(self.toggleClass[1])
                        .addClass(self.toggleClass[0])
                        .parents(self.o.widgets)
                        .removeClass('jarviswidget-collapsed')
                        .children('[role=content]')
                        .slideDown(self.o.toggleSpeed, function () {
                            self._saveSettingsWidget();
                        });
                } else {
                    tWidget.children()
                        .removeClass(self.toggleClass[0])
                        .addClass(self.toggleClass[1])
                        .parents(self.o.widgets)
                        .addClass('jarviswidget-collapsed')
                        .children('[role=content]')
                        .slideUp(self.o.toggleSpeed, function () {
                            self._saveSettingsWidget();
                        });
                }

                /**
                 * Run the callback function.
                 **/
                if (typeof self.o.onToggle == 'function') {
                    self.o.onToggle.call(this, pWidget);
                }

                e.preventDefault();
            });

            //*****************************************************************//
            ///////////////////////// FULLSCREEN WIDGETS ////////////////////////
            //*****************************************************************//

            /**
             * Set fullscreen height function.
             **/
            function heightFullscreen() {
                if ($('#jarviswidget-fullscreen-mode')
                    .length) {

                    /**
                     * Setting height variables.
                     **/
                    var heightWindow = $(window)
                        .height();
                    var heightHeader = $('#jarviswidget-fullscreen-mode')
                        .children(self.o.widgets)
                        .children('header')
                        .height();

                    /**
                     * Setting the height to the right widget.
                     **/
                    $('#jarviswidget-fullscreen-mode')
                        .children(self.o.widgets)
                        .children('div')
                        .height(heightWindow - heightHeader - 15);
                }
            }

            /**
             * On click go to fullscreen mode.
             **/
            headers.on(clickEvent, '.jarviswidget-fullscreen-btn', function (e) {

                var thisWidget = $(this)
                    .parents(self.o.widgets);
                var thisWidgetContent = thisWidget.children('div');

                /**
                 * Run function for the indicator image.
                 **/
                self._runLoaderWidget($(this));

                /**
                 * Wrap the widget and go fullsize.
                 **/
                if ($('#jarviswidget-fullscreen-mode')
                    .length) {

                    /**
                     * Remove class from the body.
                     **/
                    $('.nooverflow')
                        .removeClass('nooverflow');

                    /**
                     * Unwrap the widget, remove the height, set the right
                     * fulscreen button back, and show all other buttons.
                     **/
                    thisWidget.unwrap()
                        .children('div')
                        .removeAttr('style')
                        .end()
                        .find('.jarviswidget-fullscreen-btn:first')
                        .children()
                        .removeClass(self.fullscreenClass[1])
                        .addClass(self.fullscreenClass[0])
                        .parents(self.pwCtrls)
                        .children('a')
                        .show();

                    /**
                     * Reset collapsed widgets.
                     **/
                    if (thisWidgetContent.hasClass('jarviswidget-visible')) {
                        thisWidgetContent.hide()
                            .removeClass('jarviswidget-visible');
                    }

                } else {

                    /**
                     * Prevent the body from scrolling.
                     **/
                    $('body')
                        .addClass('nooverflow');

                    /**
					 * Wrap, append it to the body, show the right button

					 * and hide all other buttons.
					 **/
                    thisWidget.wrap('<div id="jarviswidget-fullscreen-mode"/>')
                        .parent()
                        .find('.jarviswidget-fullscreen-btn:first')
                        .children()
                        .removeClass(self.fullscreenClass[0])
                        .addClass(self.fullscreenClass[1])
                        .parents(self.pwCtrls)
                        .children('a:not(.jarviswidget-fullscreen-btn)')
                        .hide();

                    /**
                     * Show collapsed widgets.
                     **/
                    if (thisWidgetContent.is(':hidden')) {
                        thisWidgetContent.show()
                            .addClass('jarviswidget-visible');
                    }
                }

                /**
                 * Run the set height function.
                 **/
                heightFullscreen();

                /**
                 * Run the callback function.
                 **/
                if (typeof self.o.onFullscreen == 'function') {
                    self.o.onFullscreen.call(this, thisWidget);
                }

                e.preventDefault();
            });

            /**
             * Run the set fullscreen height function when the screen resizes.
             **/
            $(window)
                .on('resize.' + pluginName, function () {

                    /**
                     * Run the set height function.
                     **/
                    heightFullscreen();
                });

            //*****************************************************************//
            //////////////////////////// EDIT WIDGETS ///////////////////////////
            //*****************************************************************//

            /**
             * Allow users to show/hide a edit box.
             **/
            headers.on(clickEvent, '.jarviswidget-edit-btn', function (e) {

                var tWidget = $(this)
                    .parents(self.o.widgets);

                /**
                 * Run function for the indicator image.
                 **/
                self._runLoaderWidget($(this));

                /**
                 * Show/hide the edit box.
                 **/
                if (tWidget.find(self.o.editPlaceholder)
                    .is(':visible')) {
                    $(this)
                        .children()
                        .removeClass(self.editClass[1])
                        .addClass(self.editClass[0])
                        .parents(self.o.widgets)
                        .find(self.o.editPlaceholder)
                        .slideUp(self.o.editSpeed, function () {
                            self._saveSettingsWidget();
                        });
                } else {
                    $(this)
                        .children()
                        .removeClass(self.editClass[0])
                        .addClass(self.editClass[1])
                        .parents(self.o.widgets)
                        .find(self.o.editPlaceholder)
                        .slideDown(self.o.editSpeed);
                }

                /**
                 * Run the callback function.
                 **/
                if (typeof self.o.onEdit == 'function') {
                    self.o.onEdit.call(this, tWidget);
                }

                e.preventDefault();
            });

            /**
             * Update the widgets title by using the edit input.
             **/
            $(self.o.editPlaceholder)
                .find('input')
                .keyup(function () {
                    $(this)
                        .parents(self.o.widgets)
                        .children('header')
                        .children().first()
                        .children('h2')
                        .text($(this)
                            .val());
                });

            /**
             * Set a custom style.
             **/
            headers.on(clickEvent, '[data-widget-setstyle]', function (e) {

                var val = $(this)
                    .data('widget-setstyle');
                var styles = '';

                /**
                 * Get all other styles, in order to remove it.
                 **/
                $(this)
                    .parents(self.o.editPlaceholder)
                    .find('[data-widget-setstyle]')
                    .each(function () {
                        styles += $(this)
                            .data('widget-setstyle') + ' ';
                    });

                /**
                 * Set the new style.
                 **/
                $(this)
                    .parents(self.o.widgets)
                    .attr('data-widget-attstyle', '' + val + '')
                    .removeClassPrefix('jarviswidget-color-')
                    .addClass(val);

                /**
                 * Run function for the indicator image.
                 **/
                self._runLoaderWidget($(this));

                /**
                 * Lets save the setings.
                 **/
                self._saveSettingsWidget();

                e.preventDefault();
            });

            //*****************************************************************//
            /////////////////////////// CUSTOM ACTION ///////////////////////////
            //*****************************************************************//

            /**
             * Allow users to show/hide a edit box.
             **/
            headers.on(clickEvent, '.jarviswidget-custom-btn', function (e) {

                var w = $(this)
                    .parents(self.o.widgets);

                /**
                 * Run function for the indicator image.
                 **/
                self._runLoaderWidget($(this));

                /**
                 * Start and end custom action.
                 **/
                if ($(this)
                    .children('.' + self.customClass[0])
                    .length) {
                    $(this)
                        .children()
                        .removeClass(self.customClass[0])
                        .addClass(self.customClass[1]);

                    /**
                     * Run the callback function.
                     **/
                    if (typeof self.o.customStart == 'function') {
                        self.o.customStart.call(this, w);
                    }
                } else {
                    $(this)
                        .children()
                        .removeClass(self.customClass[1])
                        .addClass(self.customClass[0]);

                    /**
                     * Run the callback function.
                     **/
                    if (typeof self.o.customEnd == 'function') {
                        self.o.customEnd.call(this, w);
                    }
                }

                /**
                 * Lets save the setings.
                 **/
                self._saveSettingsWidget();

                e.preventDefault();
            });

            //*****************************************************************//
            /////////////////////////// DELETE WIDGETS //////////////////////////
            //*****************************************************************//

            /**
             * Allow users to delete the widgets.
             **/
            headers.on(clickEvent, '.jarviswidget-delete-btn', function (e) {

                var tWidget = $(this)
                    .parents(self.o.widgets);
                var removeId = tWidget.attr('id');
                var widTitle = tWidget.children('header')
                    .children('h2')
                    .text();

                /**
                 * Delete the widgets with a confirm popup.
                 **/
                
                if ($.SmartMessageBox) {
   
                   $.SmartMessageBox({
	                    title: "<i class='fa fa-times' style='color:#ed1c24'></i> " + self.o.labelDelete +
	                        ' "' + widTitle + '"',
	                    content: self.o.deleteMsg,
	                    buttons: '[No][Yes]'
	                }, function (ButtonPressed) {
	                    //console.log(ButtonPressed);
	                    if (ButtonPressed == "Yes") {
	                        /**
	                         * Run function for the indicator image.
	                         **/
	                        self._runLoaderWidget($(this));
	
	                        /**
	                         * Delete the right widget.
	                         **/
	                        $('#' + removeId)
	                            .fadeOut(self.o.deleteSpeed, function () {
	
	                                $(this)
	                                    .remove();
	
	                                /**
	                                 * Run the callback function.
	                                 **/
	                                if (typeof self.o.onDelete == 'function') {
	                                    self.o.onDelete.call(this, tWidget);
	                                }
	                            });
	                    }
	
	                });
	                	
                } else {
                	
                	/**
                     * Delete the right widget.
                     **/
                    $('#' + removeId)
                    .fadeOut(self.o.deleteSpeed, function () {

                        $(this)
                            .remove();

                        /**
                         * Run the callback function.
                         **/
                        if (typeof self.o.onDelete == 'function') {
                            self.o.onDelete.call(this, tWidget);
                        }
                    });
                	
                }

                e.preventDefault();
            });

            //******************************************************************//
            /////////////////////////// REFRESH BUTTON ///////////////////////////
            //******************************************************************//

            /**
             * Refresh ajax upon clicking refresh link.
             **/
            headers.on(clickEvent, '.jarviswidget-refresh-btn', function (e) {

                /**
                 * Variables.
                 **/
                var rItem = $(this)
                    .parents(self.o.widgets),
                    pathToFile = rItem.data('widget-load'),
                    ajaxLoader = rItem.children(),
                    btn = $(this);

                /**
                 * Run the ajax function.
                 **/
                btn.button('loading');
                ajaxLoader.addClass("widget-body-ajax-loading");
                setTimeout(function () {
                    btn.button('reset');
                    ajaxLoader.removeClass("widget-body-ajax-loading");
                    self._loadAjaxFile(rItem, pathToFile, ajaxLoader);

                }, 1000);

                e.preventDefault();
            });
			
			headers = null;
        },

        /**
         * Destroy.
         *
         * @param:
         **/
        destroy: function () {
            var self = this, 
            namespace = '.' + pluginName, 
            sortItem = self.obj.find(self.o.grid + '.sortable-grid').not('[data-widget-excludegrid]');
            
            sortItem.sortable('destroy');
            self.widget.children('header').off(namespace);
			$(self.o.deleteSettingsKey).off(namespace);
			$(self.o.deletePositionKey).off(namespace);
			$(window).off(namespace);
            self.obj.removeData(pluginName);
        }
    };

    $.fn[pluginName] = function (option) {
        return this.each(function () {
            var $this = $(this);
            var data = $this.data(pluginName);
            if (!data) {
				var options = typeof option == 'object' && option;
                $this.data(pluginName, (data = new Plugin(this, options)));
            }
            if (typeof option == 'string') {
                data[option]();
            }
        });
    };

    /**
     * Default settings(dont change).
     * You can globally override these options
     * by using $.fn.pluginName.key = 'value';
     **/

    $.fn[pluginName].defaults = {
        grid: 'section',
        widgets: '.jarviswidget',
        localStorage: true,
        deleteSettingsKey: '',
        settingsKeyLabel: 'Reset settings?',
        deletePositionKey: '',
        positionKeyLabel: 'Reset position?',
        sortable: true,
        buttonsHidden: false,
        toggleButton: true,
        toggleClass: 'min-10 | plus-10',
        toggleSpeed: 200,
        onToggle: function () {},
        deleteButton: true,
        deleteMsg:'Warning: This action cannot be undone',
        deleteClass: 'trashcan-10',
        deleteSpeed: 200,
        onDelete: function () {},
        editButton: true,
        editPlaceholder: '.jarviswidget-editbox',
        editClass: 'pencil-10 | delete-10',
        editSpeed: 200,
        onEdit: function () {},
        colorButton: true,
        fullscreenButton: true,
        fullscreenClass: 'fullscreen-10 | normalscreen-10',
        fullscreenDiff: 3,
        onFullscreen: function () {},
        customButton: true,
        customClass: '',
        customStart: function () {},
        customEnd: function () {},
        buttonOrder: '%refresh% %delete% %custom% %edit% %fullscreen% %toggle%',
        opacity: 1.0,
        dragHandle: '> header',
        placeholderClass: 'jarviswidget-placeholder',
        indicator: true,
        indicatorTime: 600,
        ajax: true,
        loadingLabel: 'loading...',
        timestampPlaceholder: '.jarviswidget-timestamp',
        timestampFormat: 'Last update: %m%/%d%/%y% %h%:%i%:%s%',
        refreshButton: true,
        refreshButtonClass: 'refresh-10',
        labelError: 'Sorry but there was a error:',
        labelUpdated: 'Last Update:',
        labelRefresh: 'Refresh',
        labelDelete: 'Delete widget:',
        afterLoad: function () {},
        rtl: false,
        onChange: function () {},
        onSave: function () {},
        ajaxnav: true
    };

    /*
     * REMOVE CSS CLASS WITH PREFIX
     * Description: Remove classes that have given prefix. You have an element with classes
     * 				"widget widget-color-red"
     * Usage: $elem.removeClassPrefix('widget-color-');
     */

    $.fn.removeClassPrefix = function (prefix) {

        this.each(function (i, it) {
            var classes = it.className.split(" ")
                .map(function (item) {
                    return item.indexOf(prefix) === 0 ? "" : item;
                });
            //it.className = classes.join(" ");
            it.className = $.trim(classes.join(" "));

        });

        return this;
    };
})(jQuery, window, document);
/*
 * SMART CHAT ENGINE (EXTENTION)
 * Copyright (c) 2013 Wen Pu
 * Modified by MyOrange
 * All modifications made are hereby copyright (c) 2014-2015 SmartAdmin
 */

// clears the variable if left blank
// Need this to make IE happy
// see http://soledadpenades.com/2007/05/17/arrayindexof-in-internet-explorer/
/*if (!Array.indexOf) {
    Array.prototype.indexOf = function (obj) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == obj) {
                return i;
            }
        }
        return -1;
    }
}*/

var chatboxManager = function () {
		
    var init = function (options) {
        $.extend(chatbox_config, options)
    };


    var delBox = function (id) {
        // TODO
    };

    var getNextOffset = function () {
        return (chatbox_config.width + chatbox_config.gap) * showList.length;
    };

    var boxClosedCallback = function (id) {
        // close button in the titlebar is clicked
        var idx = showList.indexOf(id);
        if (idx != -1) {
            showList.splice(idx, 1);
            diff = chatbox_config.width + chatbox_config.gap;
            for (var i = idx; i < showList.length; i++) {
                offset = $("#" + showList[i]).chatbox("option", "offset");
                $("#" + showList[i]).chatbox("option", "offset", offset - diff);
            }
        } else {
            alert("NOTE: Id missing from array: " + id);
        }
    };

    // caller should guarantee the uniqueness of id
    var addBox = function (id, user, name) {
        var idx1 = showList.indexOf(id);
        var idx2 = boxList.indexOf(id);
        if (idx1 != -1) {
            // found one in show box, do nothing
        } else if (idx2 != -1) {
            // exists, but hidden
            // show it and put it back to showList
            $("#" + id).chatbox("option", "offset", getNextOffset());
            var manager = $("#" + id).chatbox("option", "boxManager");
            manager.toggleBox();
            showList.push(id);
        } else {
            var el = document.createElement('div');
            el.setAttribute('id', id);
            $(el).chatbox({
                id: id,
                user: user,
                title: '<i title="' + user.status + '"></i>' + user.first_name + " " + user.last_name,
                hidden: false,
                offset: getNextOffset(),
                width: chatbox_config.width,
                status: user.status,
                alertmsg: user.alertmsg,
                alertshow: user.alertshow,
                messageSent: dispatch,
                boxClosed: boxClosedCallback
            });
            boxList.push(id);
            showList.push(id);
            nameList.push(user.first_name);
        }
    };

    var messageSentCallback = function (id, user, msg) {
        var idx = boxList.indexOf(id);
        chatbox_config.messageSent(nameList[idx], msg);
    };

    // not used in demo
    var dispatch = function (id, user, msg) {
        //$("#log").append("<i>" + moment().calendar() + "</i> you said to <b>" + user.first_name + " " + user.last_name + ":</b> " + msg + "<br/>");
        if ($('#chatlog').doesExist()){
        	$("#chatlog").append("You said to <b>" + user.first_name + " " + user.last_name + ":</b> " + msg + "<br/>").effect("highlight", {}, 500);;
        }
        $("#" + id).chatbox("option", "boxManager").addMsg("Me", msg);
    }

    return {
        init: init,
        addBox: addBox,
        delBox: delBox,
        dispatch: dispatch
    };
}();


$('a[data-chat-id]:not(.offline)').click(function (event, ui) {

    var $this = $(this),
        temp_chat_id = $this.attr("data-chat-id"),
        fname = $this.attr("data-chat-fname"),
        lname = $this.attr("data-chat-lname"),
        status = $this.attr("data-chat-status") || "online",
        alertmsg = $this.attr("data-chat-alertmsg"),
        alertshow =  $this.attr("data-chat-alertshow") || false;


    chatboxManager.addBox(temp_chat_id, {
        // dest:"dest" + counter, 
        // not used in demo
        title: "username" + temp_chat_id,
        first_name: fname,
        last_name: lname,
        status: status,
        alertmsg: alertmsg,
        alertshow: alertshow
        //you can add your own options too
    });

    event.preventDefault();

});
/*
 * SMART CHAT ENGINE
 * Copyright (c) 2013 Wen Pu
 * Modified by MyOrange
 * All modifications made are hereby copyright (c) 2014-2015 SmartAdmin
 */

// TODO: implement destroy()
(function($) {
    $.widget("ui.chatbox", {
        options: {
            id: null, //id for the DOM element
            title: null, // title of the chatbox
            user: null, // can be anything associated with this chatbox
            hidden: false,
            offset: 0, // relative to right edge of the browser window
            width: 300, // width of the chatbox
            status: 'online', //
            alertmsg: null,
            alertshow: null,
            messageSent: function(id, user, msg) {
                // override this
                this.boxManager.addMsg(user.first_name, msg);
            },
            boxClosed: function(id) {
            }, // called when the close icon is clicked
            boxManager: {
                // thanks to the widget factory facility
                // similar to http://alexsexton.com/?p=51
                init: function(elem) {
                    this.elem = elem;
                },
                addMsg: function(peer, msg) {
                    var self = this;
                    var box = self.elem.uiChatboxLog;
                    var e = document.createElement('div');
                    box.append(e);
                    $(e).hide();

                    var systemMessage = false;

                    if (peer) {
                        var peerName = document.createElement("b");
                        $(peerName).text(peer + ": ");
                        e.appendChild(peerName);
                    } else {
                        systemMessage = true;
                    }

                    var msgElement = document.createElement(
                        systemMessage ? "i" : "span");
                    $(msgElement).text(msg);
                    e.appendChild(msgElement);
                    $(e).addClass("ui-chatbox-msg");
                    $(e).css("maxWidth", $(box).width());
                    $(e).fadeIn();
                    //$(e).prop( 'title', moment().calendar() ); // add dep: moment.js
                    $(e).find("span").emoticonize(); // add dep: jquery.cssemoticons.js
                    self._scrollToBottom();

                    if (!self.elem.uiChatboxTitlebar.hasClass("ui-state-focus")
                        && !self.highlightLock) {
                        self.highlightLock = true;
                        self.highlightBox();
                    }
                },
                highlightBox: function() {
                    var self = this;
                    self.elem.uiChatboxTitlebar.effect("highlight", {}, 300);
                    self.elem.uiChatbox.effect("bounce", {times: 2}, 300, function() {
                        self.highlightLock = false;
                        self._scrollToBottom();
                    });
                },
                toggleBox: function() {
                    this.elem.uiChatbox.toggle();
                },
                _scrollToBottom: function() {
                    var box = this.elem.uiChatboxLog;
                    box.scrollTop(box.get(0).scrollHeight);
                }
            }
        },
        toggleContent: function(event) {
            this.uiChatboxContent.toggle();
            if (this.uiChatboxContent.is(":visible")) {
                this.uiChatboxInputBox.focus();
            }
        },
        widget: function() {
            return this.uiChatbox
        },
        _create: function() {
            var self = this,
            options = self.options,
            title = options.title || "No Title",
            // chatbox
            uiChatbox = (self.uiChatbox = $('<div></div>'))
                .appendTo(document.body)
                .addClass('ui-widget ' +
                          //'ui-corner-top ' +
                          'ui-chatbox'
                         )
                .attr('outline', 0)
                .focusin(function() {
                    // ui-state-highlight is not really helpful here
                    //self.uiChatbox.removeClass('ui-state-highlight');
                    self.uiChatboxTitlebar.addClass('ui-state-focus');
                })
                .focusout(function() {
                    self.uiChatboxTitlebar.removeClass('ui-state-focus');
                }),
            // titlebar
            uiChatboxTitlebar = (self.uiChatboxTitlebar = $('<div></div>'))
                .addClass('ui-widget-header ' +
                          //'ui-corner-top ' +
                          'ui-chatbox-titlebar ' +
                          self.options.status +
                          ' ui-dialog-header' // take advantage of dialog header style
                         )
                .click(function(event) {
                    self.toggleContent(event);
                })
                .appendTo(uiChatbox),
            uiChatboxTitle = (self.uiChatboxTitle = $('<span></span>'))
                .html(title)
                .appendTo(uiChatboxTitlebar),
            uiChatboxTitlebarClose = (self.uiChatboxTitlebarClose = $('<a href="#" rel="tooltip" data-placement="top" data-original-title="Hide"></a>'))
                .addClass(//'ui-corner-all ' +
                          'ui-chatbox-icon '
                         )
                .attr('role', 'button')
                .hover(function() { uiChatboxTitlebarClose.addClass('ui-state-hover'); },
                       function() { uiChatboxTitlebarClose.removeClass('ui-state-hover'); })
                .click(function(event) {
                    uiChatbox.hide();
                    self.options.boxClosed(self.options.id);
                    return false;
                })
                .appendTo(uiChatboxTitlebar),
            uiChatboxTitlebarCloseText = $('<i></i>')
                .addClass('fa ' +
                          'fa-times')
                .appendTo(uiChatboxTitlebarClose),
            uiChatboxTitlebarMinimize = (self.uiChatboxTitlebarMinimize = $('<a href="#" rel="tooltip" data-placement="top" data-original-title="Minimize"></a>'))
                .addClass(//'ui-corner-all ' +
                          'ui-chatbox-icon'
                         )
                .attr('role', 'button')
                .hover(function() { uiChatboxTitlebarMinimize.addClass('ui-state-hover'); },
                       function() { uiChatboxTitlebarMinimize.removeClass('ui-state-hover'); })
                .click(function(event) {
                    self.toggleContent(event);
                    return false;
                })
                .appendTo(uiChatboxTitlebar),
            uiChatboxTitlebarMinimizeText = $('<i></i>')
                .addClass('fa ' +
                          'fa-minus')
                .appendTo(uiChatboxTitlebarMinimize),
            // content
            uiChatboxContent = (self.uiChatboxContent = $('<div class="'+ self.options.alertshow +'"><span class="alert-msg">'+ self.options.alertmsg + '</span></div>'))
                .addClass('ui-widget-content ' +
                          'ui-chatbox-content '
                         )
                .appendTo(uiChatbox),
            uiChatboxLog = (self.uiChatboxLog = self.element)
                .addClass('ui-widget-content ' +
                          'ui-chatbox-log ' +
                          'custom-scroll'
                         )
                .appendTo(uiChatboxContent),
            uiChatboxInput = (self.uiChatboxInput = $('<div></div>'))
                .addClass('ui-widget-content ' +
                          'ui-chatbox-input'
                         )
                .click(function(event) {
                    // anything?
                })
                .appendTo(uiChatboxContent),
            uiChatboxInputBox = (self.uiChatboxInputBox = $('<textarea></textarea>'))
                .addClass('ui-widget-content ' +
                          'ui-chatbox-input-box '
                         )
                .appendTo(uiChatboxInput)
                .keydown(function(event) {
                    if (event.keyCode && event.keyCode == $.ui.keyCode.ENTER) {
                        msg = $.trim($(this).val());
                        if (msg.length > 0) {
                            self.options.messageSent(self.options.id, self.options.user, msg);
                        }
                        $(this).val('');
                        return false;
                    }
                })
                .focusin(function() {
                    uiChatboxInputBox.addClass('ui-chatbox-input-focus');
                    var box = $(this).parent().prev();
                    box.scrollTop(box.get(0).scrollHeight);
                })
                .focusout(function() {
                    uiChatboxInputBox.removeClass('ui-chatbox-input-focus');
                });

            // disable selection
            uiChatboxTitlebar.find('*').add(uiChatboxTitlebar).disableSelection();

            // switch focus to input box when whatever clicked
            uiChatboxContent.children().click(function() {
                // click on any children, set focus on input box
                self.uiChatboxInputBox.focus();
            });

            self._setWidth(self.options.width);
            self._position(self.options.offset);

            self.options.boxManager.init(self);

            if (!self.options.hidden) {
                uiChatbox.show();
            }
            
            $(".ui-chatbox [rel=tooltip]").tooltip();
            //console.log("tooltip created");
        },
        _setOption: function(option, value) {
            if (value != null) {
                switch (option) {
                case "hidden":
                    if (value)
                        this.uiChatbox.hide();
                    else
                        this.uiChatbox.show();
                    break;
                case "offset":
                    this._position(value);
                    break;
                case "width":
                    this._setWidth(value);
                    break;
                }
            }
            $.Widget.prototype._setOption.apply(this, arguments);
        },
        _setWidth: function(width) {
        	this.uiChatbox.width((width + 28) + "px");
            //this.uiChatboxTitlebar.width((width + 28) + "px");
            //this.uiChatboxLog.width(width + "px");
           // this.uiChatboxInput.css("maxWidth", width + "px");
            // padding:2, boarder:2, margin:5
            this.uiChatboxInputBox.css("width", (width + 18) + "px");
        },
        _position: function(offset) {
            this.uiChatbox.css("right", offset);
        }
    });
}(jQuery));


/*
 * jQuery CSSEmoticons plugin 0.2.9
 *
 * Copyright (c) 2010 Steve Schwartz (JangoSteve)
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Date: Sun Oct 22 1:00:00 2010 -0500
 */
(function($) {
  $.fn.emoticonize = function(options) {

    var opts = $.extend({}, $.fn.emoticonize.defaults, options);
    
    var escapeCharacters = [ ")", "(", "*", "[", "]", "{", "}", "|", "^", "<", ">", "\\", "?", "+", "=", "." ];
    
    var threeCharacterEmoticons = [
        // really weird bug if you have :{ and then have :{) in the same container anywhere *after* :{ then :{ doesn't get matched, e.g. :] :{ :) :{) :) :-) will match everything except :{
        //  But if you take out the :{) or even just move :{ to the right of :{) then everything works fine. This has something to do with the preMatch string below I think, because
        //  it'll work again if you set preMatch equal to '()'
        //  So for now, we'll just remove :{) from the emoticons, because who actually uses this mustache man anyway?
      // ":{)",
      ":-)", ":o)", ":c)", ":^)", ":-D", ":-(", ":-9", ";-)", ":-P", ":-p", ":-Þ", ":-b", ":-O", ":-/", ":-X", ":-#", ":'(", "B-)", "8-)", ";*(", ":-*", ":-\\",
      "?-)", // <== This is my own invention, it's a smiling pirate (with an eye-patch)!
      // and the twoCharacterEmoticons from below, but with a space inserted
      ": )", ": ]", "= ]", "= )", "8 )", ": }", ": D", "8 D", "X D", "x D", "= D", ": (", ": [", ": {", "= (", "; )", "; ]", "; D", ": P", ": p", "= P", "= p", ": b", ": Þ", ": O", "8 O", ": /", "= /", ": S", ": #", ": X", "B )", ": |", ": \\", "= \\", ": *", ": &gt;", ": &lt;"//, "* )"
    ];
    
    var twoCharacterEmoticons = [ // separate these out so that we can add a letter-spacing between the characters for better proportions
      ":)", ":]", "=]", "=)", "8)", ":}", ":D", ":(", ":[", ":{", "=(", ";)", ";]", ";D", ":P", ":p", "=P", "=p", ":b", ":Þ", ":O", ":/", "=/", ":S", ":#", ":X", "B)", ":|", ":\\", "=\\", ":*", ":&gt;", ":&lt;"//, "*)"
    ];
    
    var specialEmoticons = { // emoticons to be treated with a special class, hash specifies the additional class to add, along with standard css-emoticon class
      "&gt;:)": { cssClass: "red-emoticon small-emoticon spaced-emoticon" },
      "&gt;;)": { cssClass: "red-emoticon small-emoticon spaced-emoticon"},
      "&gt;:(": { cssClass: "red-emoticon small-emoticon spaced-emoticon" },
      "&gt;: )": { cssClass: "red-emoticon small-emoticon" },
      "&gt;; )": { cssClass: "red-emoticon small-emoticon"},
      "&gt;: (": { cssClass: "red-emoticon small-emoticon" },
      ";(":     { cssClass: "red-emoticon spaced-emoticon" },
      "&lt;3":  { cssClass: "pink-emoticon counter-rotated" },
      "O_O":    { cssClass: "no-rotate" },
      "o_o":    { cssClass: "no-rotate" },
      "0_o":    { cssClass: "no-rotate" },
      "O_o":    { cssClass: "no-rotate" },
      "T_T":    { cssClass: "no-rotate" },
      "^_^":    { cssClass: "no-rotate" },
      "O:)":    { cssClass: "small-emoticon spaced-emoticon" },
      "O: )":   { cssClass: "small-emoticon" },
      "8D":     { cssClass: "small-emoticon spaced-emoticon" },
      "XD":     { cssClass: "small-emoticon spaced-emoticon" },
      "xD":     { cssClass: "small-emoticon spaced-emoticon" },
      "=D":     { cssClass: "small-emoticon spaced-emoticon" },
      "8O":     { cssClass: "small-emoticon spaced-emoticon" },
      "[+=..]":  { cssClass: "no-rotate nintendo-controller" }
      //"OwO":  { cssClass: "no-rotate" }, // these emoticons overflow and look weird even if they're made even smaller, could probably fix this with some more css trickery
      //"O-O":  { cssClass: "no-rotate" },
      //"O=)":    { cssClass: "small-emoticon" } 
    }
    
    var specialRegex = new RegExp( '(\\' + escapeCharacters.join('|\\') + ')', 'g' );
    // One of these characters must be present before the matched emoticon, or the matched emoticon must be the first character in the container HTML
    //  This is to ensure that the characters in the middle of HTML properties or URLs are not matched as emoticons
    //  Below matches ^ (first character in container HTML), \s (whitespace like space or tab), or \0 (NULL character)
    // (<\\S+.*>) matches <\\S+.*> (matches an HTML tag like <span> or <div>), but haven't quite gotten it working yet, need to push this fix now
    var preMatch = '(^|[\\s\\0])';
    
    for ( var i=threeCharacterEmoticons.length-1; i>=0; --i ){
      threeCharacterEmoticons[i] = threeCharacterEmoticons[i].replace(specialRegex,'\\$1');
      threeCharacterEmoticons[i] = new RegExp( preMatch+'(' + threeCharacterEmoticons[i] + ')', 'g' );
    }
    
    for ( var i=twoCharacterEmoticons.length-1; i>=0; --i ){
      twoCharacterEmoticons[i] = twoCharacterEmoticons[i].replace(specialRegex,'\\$1');
      twoCharacterEmoticons[i] = new RegExp( preMatch+'(' + twoCharacterEmoticons[i] + ')', 'g' );
    }
    
    for ( var emoticon in specialEmoticons ){
      specialEmoticons[emoticon].regexp = emoticon.replace(specialRegex,'\\$1');
      specialEmoticons[emoticon].regexp = new RegExp( preMatch+'(' + specialEmoticons[emoticon].regexp + ')', 'g' );
    }
    
    var exclude = 'span.css-emoticon';
    if(opts.exclude){ exclude += ','+opts.exclude; }
    var excludeArray = exclude.split(',')

    return this.not(exclude).each(function() {
      var container = $(this);
      var cssClass = 'css-emoticon'
      if(opts.animate){ cssClass += ' un-transformed-emoticon animated-emoticon'; }
      
      for( var emoticon in specialEmoticons ){
        specialCssClass = cssClass + " " + specialEmoticons[emoticon].cssClass;
        container.html(container.html().replace(specialEmoticons[emoticon].regexp,"$1<span class='" + specialCssClass + "'>$2</span>"));
      }
      $(threeCharacterEmoticons).each(function(){
        container.html(container.html().replace(this,"$1<span class='" + cssClass + "'>$2</span>"));
      });                                                          
      $(twoCharacterEmoticons).each(function(){                    
        container.html(container.html().replace(this,"$1<span class='" + cssClass + " spaced-emoticon'>$2</span>"));
      });
      // fix emoticons that got matched more then once (where one emoticon is a subset of another emoticon), and thus got nested spans
      $.each(excludeArray,function(index,item){
        container.find($.trim(item)+" span.css-emoticon").each(function(){
          $(this).replaceWith($(this).text());
        });
      });
      if(opts.animate){
        setTimeout(function(){$('.un-transformed-emoticon').removeClass('un-transformed-emoticon');}, opts.delay);
      }
    });
  }
  
  $.fn.unemoticonize = function(options) {
    var opts = $.extend({}, $.fn.emoticonize.defaults, options);
    return this.each(function() {
      var container = $(this);
      container.find('span.css-emoticon').each(function(){
        // add delay equal to animate speed if animate is not false
        var span = $(this);
        if(opts.animate){
          span.addClass('un-transformed-emoticon');
          setTimeout(function(){span.replaceWith(span.text());}, opts.delay); 
        }else{
          span.replaceWith(span.text());
        }
      });
    });
  }

  $.fn.emoticonize.defaults = {animate: true, delay: 500, exclude: 'pre,code,.no-emoticons'}
})(jQuery);

/**
 * SuperBox
 * The lightbox reimagined. Fully responsive HTML5 image galleries.
 * 
 * Latest version: https://github.com/seyDoggy/superbox
 * Original version: https://github.com/toddmotto/superbox
 * 
 * License <https://github.com/seyDoggy/superbox/blob/master/LICENSE.txt>
 */
 ;(function($, undefined) {
	'use strict';

	var pluginName = 'SuperBox',
		pluginVersion = '3.1.0';

	$.fn.SuperBox = function(options) {

		/*
		 * OPTIONS
		 */
		var defaults = $.extend({
			background : null,
			border : null,
			height : 400,
			view : 'landscape',
			xColor : null,
			xShadow : 'none'
		}, options);

		/*
		 * DECLARATIONS
		 */
		var sbIsIconShown = false,
			sbIsNavReady = false,
			sbShow = $('<div class="superbox-show"/>'),
			sbImg = $('<img src="img/ajax-loader.gif" class="superbox-current-img"/>'),
			sbClose = $('<a href="#" class="superbox-close"><i class="icon-remove-sign"></i></a>'),
			sbPrev = $('<a href="#" class="superbox-prev"><i class="icon-circle-arrow-left"></i></a>'),
			sbNext = $('<a href="#" class="superbox-next"><i class="icon-circle-arrow-right"></i></a>'),
			sbFloat = $('<div class="superbox-float"/>'),
			sbList = this.find('>div'),
			sbList8 = this.find('>div:nth-child(8n)'),
			sbList6 = this.find('>div:nth-child(6n)'),
			sbList4 = this.find('>div:nth-child(4n)'),
			sbList2 = this.find('>div:nth-child(2n)'),
			sbWrapper = this;

		/*
		 * METHODS
		 */
		/**
		 * setSuperboxLayout
		 * 
		 * Removes previously set classes,
		 * Add classes based on parent width,
		 * Set .superbox.show width based number of columns
		 */
		var setSuperboxLayout = function(num){
			var setColumns = function(num){
				var lastItem,
					columnClass = 'superbox-' + num,
					classArray = ['superbox-last','superbox-8','superbox-6','superbox-4','superbox-2'];
				if (num === 8) {
					lastItem = sbList8;
				} else if (num === 6) {
					lastItem = sbList6;
				} else if (num === 4) {
					lastItem = sbList4;
				} else if (num === 2) {
					lastItem = sbList2;
				}
				/*
				 * remove classes
				 */
				for (var i = classArray.length - 1; i >= 0; i--) {
					sbList.removeClass(classArray[i]);
				}
				/*
				 * add classes
				 */
				sbList.addClass(columnClass);
				lastItem.add(sbList.last()).addClass('superbox-last');
				/*
				 * set superbox-show width
				 */
				if (sbWrapper.find('.superbox-show').outerWidth(true) != sbList.width()*num) {
					sbWrapper.find('.superbox-show').outerWidth(sbList.width()*num);
				}
			};
			if (sbWrapper.width() > 1024) {
				setColumns(8);
			} else if (sbWrapper.width() > 767) {
				setColumns(6);
			} else if (sbWrapper.width() > 320) {
				setColumns(4);
			} else {
				setColumns(2);
			}
		};

		/**
		 * setSuperBoxHeight
		 * 
		 * Set superbox-show outer height based on default height,
		 * based on viewport height,
		 * based on standard 2:3 ratio,
		 * based on default orientation.
		 */
		var setSuperBoxHeight = (function(){
			var thisWidth = sbWrapper.find('.superbox-show').outerWidth(true),
				thisHeight = defaults.height + (16 * 3), /* 1.5em padding */
				newHeight = thisHeight,
				thisWindow = $(window).height() * 0.80,
				thisView = defaults.view,
				thisRatio = 0.6667;

			if (newHeight > thisWindow) {
				newHeight = thisWindow;
			}
			if ((thisView === 'landscape') && (thisWidth < newHeight / thisRatio)) {
				newHeight = thisWidth * thisRatio;
			}
			if ((thisView === 'portrait') && (thisWidth < newHeight * thisRatio)) {
				newHeight = thisWidth / thisRatio;
			}
			if ((thisView === 'square') && (thisWidth < newHeight)) {
				newHeight = thisWidth;
			}
			sbWrapper.find('.superbox-show').outerHeight(newHeight);
		});

		/**
		 * createSuperboxShow
		 * 
		 * Dynamically create superbox-show and insert it after superbox-last,
		 * apply data-img of the thumbnail to the source of the full image,
		 * preload previous and next full size image data into DOM,
		 * open the superbox-show,
		 * fade in and out of each image,
		 * animate image to top of clicked row,
		 * close superbox-show when X is clicked,
		 * close superbox-show when open image is clicked
		 */
		var createSuperboxShow = function(elem){
			/*
			 * DECLARATIONS (createSuperboxShow)
			 */
			var noSuperbox = !sbWrapper.find('.superbox-show').length,
				isOpen = elem.hasClass('superbox-O'),
				notLast = !elem.hasClass('superbox-last'),
				notInRow = !elem.nextAll('.superbox-last:first').next('.superbox-show').length,
				showNotNext = !elem.next('.superbox-show').length,
			/*
			 * METHODS (createSuperboxShow)
			 */
				openSuperBoxShow = function(type){
					if (type === 'A') {
						sbShow.append(sbImg).append(sbClose).append(sbPrev).append(sbNext).insertAfter(elem.nextAll('.superbox-last:first'));
					} else {
						sbShow.append(sbImg).append(sbClose).insertAfter(elem);
					}
					setSuperBoxHeight();
					setSuperboxLayout();
					setImageData();
					sbWrapper.find('.superbox-show').slideDown('slow',function(){
						moveToTop();
						setOpenClass(true);
						revealImage(true);
						if (sbIsNavReady === false) {
							sbWrapper.find('.superbox-prev,.superbox-next').on('click',function(event){
								navigation($(this),event);
								sbIsNavReady = true;
							});
							/*
							 * Keyboard navigation
							 */
							$(document.documentElement).keyup(function (event) {
								if (isScrolledIntoView() === true) {
									navigation($(this),event);
									sbIsNavReady = true;
								}
							});
						}
					});
				},
				setImageData = function(){
					sbWrapper.find('.superbox-show img.superbox-current-img').attr('src',elem.find('img').data('img'));
					preloadImageData();
				},
				preloadImageData = function(){
					var imgPrev = new Image(),
						imgNext = new Image();
					imgPrev.src = elem.prev('.superbox-list').find('img').data('img');
					imgNext.src = elem.nextAll('.superbox-list:first').find('img').data('img');
				},
				moveToTop = function(){
					$('html, body').animate({
						scrollTop:sbWrapper.find('.superbox-show').offset().top - elem.width()
					}, 'medium');
				},
				isScrolledIntoView = function (){
					var docViewTop = $(window).scrollTop();
					var docViewBottom = docViewTop + $(window).height();

					var elemTop = sbWrapper.find('.superbox-show').offset().top;
					var elemBottom = elemTop + sbWrapper.find('.superbox-show').height();

					return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
				},
				setOpenClass = function(bool){
					if (bool === true) {
						sbList.removeClass('superbox-O');
						elem.addClass('superbox-O');
					} else {
						sbList.removeClass('superbox-O');
					}
				},
				revealImage = function(bool){
					if (bool === true) {
						sbWrapper.find('.superbox-show img.superbox-current-img').animate({opacity:1},750);
						if (sbIsIconShown === false) {
							revealIcons(true);
						}
					} else {
						sbWrapper.find('.superbox-show img.superbox-current-img').animate({opacity:0},100,function(){
							setImageData();
						});
					}
				},
				revealIcons = function(bool){
					if (bool === true) {
						sbIsIconShown = true;
						sbWrapper.find('.superbox-close, .superbox-prev, .superbox-next').animate({opacity:0.7},750);
					} else {
						sbIsIconShown = false;
						sbWrapper.find('.superbox-close, .superbox-prev, .superbox-next').animate({opacity:0},100);
					}
				},
				navigation = function(select,event){
					event.preventDefault();
					var direction = null,
						selector = null;
					if (event.keyCode == 37 || select.hasClass('superbox-prev')) {
						/*
						 * go left
						 */
						direction = 'prev';
						selector = '.superbox-list';
					} else if (event.keyCode == 39 || select.hasClass('superbox-next')) {
						/*
						 * go right
						 */
						direction = 'nextAll';
						selector = '.superbox-list:first';
					}
					if (direction !== null) {
						sbWrapper.find('.superbox-O')[direction](selector).click();
					}
				},
				quickSwap = function(){
					revealImage(false);
					revealImage(true);
					setOpenClass(true);
				},
				closeSuperBoxShow = function(){
					var closeUp = function(){
						revealImage(false);
						revealIcons(false);
						sbWrapper.find('.superbox-show').slideUp(function(){
							$(this).remove();
							setOpenClass(false);
							sbIsNavReady = false;
						});
					};
					sbWrapper.find('.superbox-close').on('click',function(event){
						event.preventDefault();
						closeUp();
					});
					if (isOpen === true) {
						closeUp();
					}
				};

			/*
			 * IMPLEMENTATION (createSuperboxShow)
			 */
			if (isOpen === false) {
				if (notLast === true && notInRow === true) {
					if (noSuperbox === true) {
						openSuperBoxShow('A');
					} else {
						revealImage(false);
						revealIcons(false);
						sbWrapper.find('.superbox-show').slideUp(function(){
							openSuperBoxShow('A');
						});
					}
				} else if (notLast === false && showNotNext === true) {
					if (noSuperbox === true) {
						openSuperBoxShow('B');
					} else {
						revealImage(false);
						revealIcons(false);
						sbWrapper.find('.superbox-show').slideUp(function(){
							openSuperBoxShow('B');
						});
					}
				} else {
					quickSwap();
				}
			}
			closeSuperBoxShow();
		};

		/**
		 * keepShowAfterLast
		 * 
		 * Move superbox-show to after superbox-last when window is resized
		 */
		var keepShowAfterLast = function(){
			$(window).resize(function(){
				if (sbWrapper.find('.superbox-O').hasClass('superbox-last')) {
					sbWrapper.find('.superbox-show').insertAfter(sbWrapper.find('.superbox-O'));
				} else {
					sbWrapper.find('.superbox-show').insertAfter(sbWrapper.find('.superbox-O').nextAll('.superbox-last:first'));
				}
			});
		};

		/**
		 * useDefaults
		 * 
		 * Make us of and apply user settings
		 */
		var useDefaults = function(){
			if (defaults.background !== null) {
				sbWrapper.find('.superbox-show').css('background-color',defaults.background);
			}
			if (defaults.border !== null) {
				sbWrapper.find('.superbox-show img.superbox-current-img').css('border-color',defaults.border);
			}
			if (defaults.xColor !== null) {
				sbWrapper.find('.superbox-close, .superbox-prev, .superbox-next').css('color',defaults.xColor);
			}
			if (defaults.xShadow == 'emboss') {
				sbWrapper.find('.superbox-close, .superbox-prev, .superbox-next').css('text-shadow','0 1px 0 rgba(0,0,0,0.6), 0 -1px 0 rgba(250,250,250,0.2)');
			} else if (defaults.xShadow == 'embed') {
				sbWrapper.find('.superbox-close, .superbox-prev, .superbox-next').css('text-shadow','0 -1px 0 rgba(0,0,0,0.4), 0 1px 0 rgba(250,250,250,0.5)');
			}
		};

		/*
		 * IMPLEMENTATION
		 */

		/*
		 * Add superbox-active class to allow for CSS to take hold
		 */
		this.addClass('superbox-active');

		/*
		 * Add superbox-list class for easier CSS targeting
		 */
		sbList.addClass('superbox-list');

		/*
		 * Adjust superbox-show height and width based on window size
		 */
		setSuperboxLayout();
		$(window).resize(function(){
			setSuperBoxHeight();
			setSuperboxLayout();
		});

		/*
		 * Create final float
		 */
		sbFloat.appendTo(this);

		/*
		 * Preload image data when thumbnail is hovered over
		 */
		sbList.on('mouseenter',function(){
			var img = new Image(),
				source = $(this).find('img').data('img');
			$(img).attr('src',source);
		});

		/*
		 * Open/Close superbox-show based on click
		 */
		sbList.on('click',function(){
			/*
			 * Create superbox-show
			 */
			createSuperboxShow($(this));

			/*
			 * Apply user settings
			 */
			useDefaults();
		});

		/*
		 * Keep superbox-show after the proper row at all times
		 */
		keepShowAfterLast();

		return this;
	};
})(jQuery);
;

(function($) {
  $.fn.highchartTable = function() {
    
    var allowedGraphTypes = ['column', 'line', 'area', 'spline', 'pie'];

    var getCallable = function (table, attribute) {
      var callback = $(table).data(attribute);
      if (typeof callback != 'undefined') {
        var infosCallback = callback.split('.');
        var callable      = window[infosCallback[0]];
        for(var i = 1, infosCallbackLength = infosCallback.length; i < infosCallbackLength; i++) {
          callable = callable[infosCallback[i]];
        }
        return callable;
      }
    };

    this.each(function() {
      var table = $(this);
      var $table = $(table);
      var nbYaxis = 1;

      // Retrieve graph title from the table caption
      var captions   = $('caption', table);
      var graphTitle = captions.length ? $(captions[0]).text() : '';

      var graphContainer;
      if ($table.data('graph-container-before') != 1) {
        // Retrieve where the graph must be displayed from the graph-container attribute
        var graphContainerSelector = $table.data('graph-container');
        if (!graphContainerSelector) {
          throw "graph-container data attribute is mandatory";
        }

        if (graphContainerSelector[0] === '#' || graphContainerSelector.indexOf('..')===-1) {
          // Absolute selector path
          graphContainer = $(graphContainerSelector);
        } else {
          var referenceNode                 = table;
          var currentGraphContainerSelector = graphContainerSelector;

          while (currentGraphContainerSelector.indexOf('..')!==-1) {
            currentGraphContainerSelector = currentGraphContainerSelector.replace(/^.. /, '');
            referenceNode = referenceNode.parent();
          }

          graphContainer = $(currentGraphContainerSelector, referenceNode);
        }
        if (graphContainer.length !== 1) {
          throw "graph-container is not available in this DOM or available multiple times";
        }
        graphContainer = graphContainer[0];
      } else {
        $table.before('<div></div>');
        graphContainer = $table.prev();
        graphContainer = graphContainer[0];
      }

      // Retrieve graph type from graph-type attribute
      var globalGraphType = $table.data('graph-type');
      if (!globalGraphType) {
        throw "graph-type data attribute is mandatory";
      }
      if ($.inArray(globalGraphType, allowedGraphTypes) == -1) {
        throw "graph-container data attribute must be one of " + allowedGraphTypes.join(', ');
      }

      var stackingType = $table.data('graph-stacking');
      if (!stackingType) {
        stackingType = 'normal';
      }

      var dataLabelsEnabled = $table.data('graph-datalabels-enabled');
      var isGraphInverted   = $table.data('graph-inverted') == 1;

      // Retrieve series titles
      var ths            = $('thead th', table);
      var columns        = [];
      var vlines         = [];
      var skippedColumns = 0;
      var graphIsStacked = false;
      ths.each(function(indexTh, th) {
        var $th = $(th);
        var columnScale = $th.data('graph-value-scale');

        var serieGraphType = $th.data('graph-type');
        if($.inArray(serieGraphType, allowedGraphTypes) == -1) {
          serieGraphType = globalGraphType;
        }

        var serieStackGroup = $th.data('graph-stack-group');
        if(serieStackGroup) {
          graphIsStacked = true;
       }

        var serieDataLabelsEnabled = $th.data('graph-datalabels-enabled');
        if (typeof serieDataLabelsEnabled == 'undefined') {
          serieDataLabelsEnabled = dataLabelsEnabled;
        }

        var yaxis = $th.data('graph-yaxis');

        if (typeof yaxis != 'undefined' && yaxis == '1') {
          nbYaxis = 2;
        }

        var isColumnSkipped = $th.data('graph-skip') == 1;
        if (isColumnSkipped)
        {
          skippedColumns = skippedColumns + 1;
        }

        var thGraphConfig = {
          libelle:           $th.text(),
          skip:              isColumnSkipped,
          indexTd:           indexTh - skippedColumns - 1,
          color:             $th.data('graph-color'),
          visible:           !$th.data('graph-hidden'),
          yAxis:             typeof yaxis != 'undefined' ? yaxis : 0,
          dashStyle:         $th.data('graph-dash-style') || 'solid',
          dataLabelsEnabled: serieDataLabelsEnabled == 1,
          dataLabelsColor:   $th.data('graph-datalabels-color') ||  $table.data('graph-datalabels-color')

        };

        var vlinex = $th.data('graph-vline-x');
        if (typeof vlinex == 'undefined') {
          thGraphConfig.scale     = typeof columnScale != 'undefined' ? parseFloat(columnScale) : 1;
          thGraphConfig.graphType = serieGraphType == 'column' && isGraphInverted ? 'bar' : serieGraphType;
          thGraphConfig.stack     = serieStackGroup;
          thGraphConfig.unit      = $th.data('graph-unit');
          columns[indexTh]        = thGraphConfig;
        } else {
          thGraphConfig.x      = vlinex;
          thGraphConfig.height = $th.data('graph-vline-height');
          thGraphConfig.name   = $th.data('graph-vline-name');
          vlines[indexTh]      = thGraphConfig;
        }
      });
      
      var series = [];
      $(columns).each(function(indexColumn, column) {
        if(indexColumn!=0 && !column.skip) {

          var serieConfig = {
            name:      column.libelle + (column.unit ? ' (' + column.unit + ')' : ''),
            data:      [],
            type:      column.graphType,
            stack:     column.stack,
            color:     column.color,
            visible:   column.visible,
            yAxis:     column.yAxis,
            dashStyle: column.dashStyle,
            marker: {
                enabled: false
            },
            dataLabels: {
              enabled: column.dataLabelsEnabled,
              color:   column.dataLabelsColor,
              align:   $table.data('graph-datalabels-align') || (globalGraphType == 'column' && isGraphInverted == 1 ? undefined : 'center')
            }
          };

          if(column.dataLabelsEnabled) {
            var callableSerieDataLabelsFormatter = getCallable(table, 'graph-datalabels-formatter');
            if (callableSerieDataLabelsFormatter) {
              serieConfig.dataLabels.formatter = function () {
                return callableSerieDataLabelsFormatter(this.y);
              };
            }
          }
          series.push(serieConfig);
        }
      });

      $(vlines).each(function(indexColumn, vline) {
        if (typeof vline != 'undefined' && !vline.skip) {
          series.push({
            name:    vline.libelle,
            data:    [{x: vline.x, y:0, name: vline.name}, {x:vline.x, y:vline.height, name: vline.name}],
            type:    'spline',
            color:   vline.color,
            visible: vline.visible,
            marker: {
              enabled: false
            }
          });
        }
      });

      var xValues         = [];
      var callablePoint   = getCallable(table, 'graph-point-callback');
      var isGraphDatetime = $table.data('graph-xaxis-type') == 'datetime';
      
      var rows            = $('tbody:first tr', table);
      rows.each(function(indexRow, row) {
        if (!!$(row).data('graph-skip')) {
          return;
        }

        var tds = $('td', row);
        tds.each(function(indexTd, td) {
          var cellValue;
          var column = columns[indexTd];

          if (column.skip) {
            return;
          }
          var $td = $(td);
          if (indexTd==0) {
            cellValue = $td.text();
            xValues.push(cellValue);
          } else {
            var rawCellValue = $td.text();
            var serie  = series[column.indexTd];

            if (rawCellValue.length==0) {
              if (!isGraphDatetime) {
                serie.data.push(null);
              }
            } else {
              var cleanedCellValue = rawCellValue.replace(/\s/g, '').replace(/,/, '.');
              var eventOptions = {
                 value: cleanedCellValue,
                 rawValue: rawCellValue,
                 td: $td,
                 tr: $(row),
                 indexTd: indexTd,
                 indexTr: indexRow
               }
               $table.trigger('highchartTable.cleanValue', eventOptions);
               cellValue = Math.round(parseFloat(eventOptions.value) * column.scale * 100) / 100;

                var dataGraphX = $td.data('graph-x');

                if (isGraphDatetime) {
                  dataGraphX    = $('td', $(row)).first().text();
                  var date      = parseDate(dataGraphX);
                  dataGraphX    = date.getTime() - date.getTimezoneOffset()*60*1000;
                }

                var tdGraphName = $td.data('graph-name');
                var serieDataItem = {
                  name:   typeof tdGraphName != 'undefined' ? tdGraphName : rawCellValue,
                  y:      cellValue,
                  x:      dataGraphX //undefined if no x defined in table
                };

                if (callablePoint) {
                  serieDataItem.events = {
                    click: function () {
                        return callablePoint(this);
                      }
                  };
                }

                if (column.graphType === 'pie') {
                  if ($td.data('graph-item-highlight')) {
                    serieDataItem.sliced = 1;
                  }
                }

                var tdGraphItemColor = $td.data('graph-item-color');
                if (typeof tdGraphItemColor != 'undefined') {
                  serieDataItem.color =  tdGraphItemColor;
                }

              serie.data.push(serieDataItem);
            }
          }
        });

      });

      var getYaxisAttr = function($table, yAxisNum, name) {
          var oldConvention = $table.data('graph-yaxis-' + yAxisNum + '-' + name);
          if (typeof oldConvention != 'undefined') {
              return oldConvention;
          }

          return $table.data('graph-yaxis' + yAxisNum + '-' + name);
      };

      var yAxisConfig = [];
      var yAxisNum;
      for (yAxisNum=1 ; yAxisNum <= nbYaxis ; yAxisNum++) {
        var yAxisConfigCurrentAxis = {
          title: {
            text: typeof getYaxisAttr($table, yAxisNum, 'title-text') != 'undefined'  ? getYaxisAttr($table, yAxisNum, 'title-text') : null
          },
          max:          typeof getYaxisAttr($table, yAxisNum, 'max') != 'undefined' ? getYaxisAttr($table, yAxisNum, 'max') : null,
          min:          typeof getYaxisAttr($table, yAxisNum, 'min') != 'undefined' ? getYaxisAttr($table, yAxisNum, 'min') : null,
          reversed:     getYaxisAttr($table, yAxisNum, 'reversed') == '1',
          opposite:     getYaxisAttr($table, yAxisNum, 'opposite') == '1',
          tickInterval: getYaxisAttr($table, yAxisNum, 'tick-interval') || null,
          labels: {
            rotation: getYaxisAttr($table, yAxisNum, 'rotation') || 0
          },
          startOnTick: getYaxisAttr($table, yAxisNum, 'start-on-tick') != "0",
          endOnTick:   getYaxisAttr($table, yAxisNum, 'end-on-tick') != "0",
          stackLabels : {
            enabled: getYaxisAttr($table, yAxisNum, 'stacklabels-enabled') == '1'
          },
          gridLineInterpolation: getYaxisAttr($table, yAxisNum, 'grid-line-interpolation') || null
        };

        var callableYAxisFormatter = getCallable(table, 'graph-yaxis-'+yAxisNum+'-formatter-callback');

        if (!callableYAxisFormatter) {
            callableYAxisFormatter = getCallable(table, 'graph-yaxis'+yAxisNum+'-formatter-callback');
        }

        if (callableYAxisFormatter) {
          yAxisConfigCurrentAxis.labels.formatter = function () {
              return callableYAxisFormatter(this.value);
          };
        }

        yAxisConfig.push(yAxisConfigCurrentAxis);
      }

      var defaultColors = [
        '#4572A7',
        '#AA4643',
        '#89A54E',
        '#80699B',
        '#3D96AE',
        '#DB843D',
        '#92A8CD',
        '#A47D7C',
        '#B5CA92'
      ];
      var colors = [];

      var themeColors = typeof Highcharts.theme != 'undefined' && typeof Highcharts.theme.colors != 'undefined' ? Highcharts.theme.colors : [];
      var lineShadow  = $table.data('graph-line-shadow');
      var lineWidth   = $table.data('graph-line-width') || 2;

      var nbOfColors = Math.max(defaultColors.length, themeColors.length);
      for(var i=0; i < nbOfColors; i++) {
        var dataname = 'graph-color-' + (i+1);
        colors.push(typeof $table.data(dataname) != 'undefined' ? $table.data(dataname) : typeof themeColors[i] != 'undefined' ? themeColors[i] : defaultColors[i]);
      }

      var marginTop    = $table.data('graph-margin-top');
      var marginRight  = $table.data('graph-margin-right');
      var marginBottom = $table.data('graph-margin-bottom');
      var marginLeft   = $table.data('graph-margin-left');
      
      var xAxisLabelsEnabled = $table.data('graph-xaxis-labels-enabled');

      var xAxisLabelStyle = {};
      var xAxisLabelFontSize = $table.data('graph-xaxis-labels-font-size');
      
      if (typeof xAxisLabelFontSize != 'undefined')
      {
        xAxisLabelStyle.fontSize = xAxisLabelFontSize; 
      }

      var highChartConfig = {
        colors: colors,
        chart: {
          renderTo:     graphContainer,
          inverted:     isGraphInverted,
          marginTop:    typeof marginTop != 'undefined' ? marginTop : null,
          marginRight:  typeof marginRight != 'undefined' ? marginRight : null,
          marginBottom: typeof marginBottom != 'undefined' ? marginBottom : null,
          marginLeft:   typeof marginLeft != 'undefined' ? marginLeft : null,
          spacingTop:   $table.data('graph-spacing-top') || 10,
          height:       $table.data('graph-height') || null,
          zoomType:     $table.data('graph-zoom-type') || null,
          polar:        $table.data('graph-polar') || null
        },
        title: {
          text: graphTitle
        },
        subtitle: {
          text: $table.data('graph-subtitle-text') || ''
        },
        legend: {
          enabled:     $table.data('graph-legend-disabled') != '1',
          layout:      $table.data('graph-legend-layout') || 'horizontal',
          symbolWidth: $table.data('graph-legend-width') || 30,
          x:           $table.data('graph-legend-x') || 15,
          y:           $table.data('graph-legend-y') || 0
        },
        xAxis: {
          categories:             ($table.data('graph-xaxis-type') != 'datetime') ? xValues : undefined,
          type:                   ($table.data('graph-xaxis-type') == 'datetime') ? 'datetime' :  undefined,
          reversed:               $table.data('graph-xaxis-reversed') == '1',
          opposite:               $table.data('graph-xaxis-opposite') == '1',
          showLastLabel:          typeof $table.data('graph-xaxis-show-last-label') != 'undefined' ? $table.data('graph-xaxis-show-last-label') : true,
          tickInterval:           $table.data('graph-xaxis-tick-interval') || null,
          dateTimeLabelFormats:   { //by default, we display the day and month on the datetime graphs
            second: '%e. %b',
            minute: '%e. %b',
            hour:   '%e. %b',
            day:    '%e. %b',
            week:   '%e. %b',
            month:  '%e. %b',
            year:   '%e. %b'
          },
          labels:
          {
            rotation: $table.data('graph-xaxis-rotation') || undefined,
            align:    $table.data('graph-xaxis-align') || undefined, 
            enabled:  typeof xAxisLabelsEnabled != 'undefined' ? xAxisLabelsEnabled : true,
            style:    xAxisLabelStyle
          },
          startOnTick: $table.data('graph-xaxis-start-on-tick'),
          endOnTick:   $table.data('graph-xaxis-end-on-tick'),
          min: getXAxisMinMax(table, 'min'),
          max: getXAxisMinMax(table, 'max'),
          alternateGridColor: $table.data('graph-xaxis-alternateGridColor') || null,
          title: {
            text: $table.data('graph-xaxis-title-text') || null
          },
          gridLineWidth:     $table.data('graph-xaxis-gridLine-width') || 0,
          gridLineDashStyle: $table.data('graph-xaxis-gridLine-style') || 'ShortDot',
          tickmarkPlacement: $table.data('graph-xaxis-tickmark-placement') || 'between',
          lineWidth:         $table.data('graph-xaxis-line-width') || 0
        },
        yAxis: yAxisConfig,
        tooltip: {
            formatter: function() {
              if ($table.data('graph-xaxis-type') == 'datetime') {
                return '<b>'+ this.series.name +'</b><br/>'+  Highcharts.dateFormat('%e. %b', this.x) +' : '+ this.y;
              } else {
                var xValue = typeof xValues[this.point.x] != 'undefined' ? xValues[this.point.x] : this.point.x;
                if (globalGraphType === 'pie') {
                  return '<strong>' + this.series.name + '</strong><br />' + xValue + ' : '  + this.point.y;
                }
                return '<strong>' + this.series.name + '</strong><br />' + xValue + ' : '  + this.point.name;
              }
            }
        },
        credits: {
          enabled: false
        },
        plotOptions: {
          line: {
            dataLabels: {
              enabled: true
            },
            lineWidth: lineWidth
          },
          area: {
            lineWidth:   lineWidth,
            shadow:      typeof lineShadow != 'undefined' ? lineShadow : true,
            fillOpacity: $table.data('graph-area-fillOpacity') || 0.75
          },
          pie: {
            allowPointSelect: true,
            dataLabels: {
              enabled: true
            },
            showInLegend: $table.data('graph-pie-show-in-legend') == '1',
            size:         '80%'
          },
          series: {
            animation:       false,
            stickyTracking : false,
            stacking:        graphIsStacked ? stackingType : null,
            groupPadding:    $table.data('graph-group-padding') || 0
          }
        },
        series: series,
        exporting: {
            filename: graphTitle.replace(/ /g, '_'),
            buttons: {
              exportButton: {
                menuItems: null,
                onclick: function() {
                  this.exportChart();
                }
              }
            }
          }
      };

      $table.trigger('highchartTable.beforeRender', highChartConfig);
      new Highcharts.Chart(highChartConfig);

    });
    //for fluent api
    return this;
  };
  
  var getXAxisMinMax = function(table, minOrMax) {
    var value = $(table).data('graph-xaxis-'+minOrMax);
    if (typeof value != 'undefined') {
      if ($(table).data('graph-xaxis-type') == 'datetime') {
        var date      = parseDate(value);
        return date.getTime() - date.getTimezoneOffset()*60*1000;
      }
      return value;
    }
    return null;
  };

  var parseDate = function(datetime) {
    var calculatedateInfos  = datetime.split(' ');
    var dateDayInfos        = calculatedateInfos[0].split('-');
    var min                 = null;
    var hour                = null;
    // If hour and minute are available in the datetime string
    if(calculatedateInfos[1]) {
      var dateHourInfos = calculatedateInfos[1].split(':');
      min               =  parseInt(dateHourInfos[0], 10);
      hour              = parseInt(dateHourInfos[1], 10);
    }
    return new Date(parseInt(dateDayInfos[0], 10), parseInt(dateDayInfos[1], 10)-1, parseInt(dateDayInfos[2], 10), min, hour);
  };
  
})(jQuery);
/*! Jcrop.js v2.0.4 - build: 20151117
 *  @copyright 2008-2015 Tapmodo Interactive LLC
 *  @license Free software under MIT License
 *  @website http://jcrop.org/
 **/
(function($){
  'use strict';

  // Jcrop constructor
  var Jcrop = function(element,opt){
    var _ua = navigator.userAgent.toLowerCase();

    this.opt = $.extend({},Jcrop.defaults,opt || {});

    this.container = $(element);

    this.opt.is_msie = /msie/.test(_ua);
    this.opt.is_ie_lt9 = /msie [1-8]\./.test(_ua);

    this.container.addClass(this.opt.css_container);

    this.ui = {};
    this.state = null;
    this.ui.multi = [];
    this.ui.selection = null;
    this.filter = {};

    this.init();
    this.setOptions(opt);
    this.applySizeConstraints();
    this.container.trigger('cropinit',this);
      
    // IE<9 doesn't work if mouse events are attached to window
    if (this.opt.is_ie_lt9)
      this.opt.dragEventTarget = document.body;
  };


  // Jcrop static functions
  $.extend(Jcrop,{
    component: { },
    filter: { },
    stage: { },
    registerComponent: function(name,component){
      Jcrop.component[name] = component;
    },
    registerFilter: function(name,filter){
      Jcrop.filter[name] = filter;
    },
    registerStageType: function(name,stage){
      Jcrop.stage[name] = stage;
    },
    // attach: function(element,opt){{{
    attach: function(element,opt){
      var obj = new $.Jcrop(element,opt);
      return obj;
    },
    // }}}
    // imgCopy: function(imgel){{{
    imgCopy: function(imgel){
      var img = new Image;
      img.src = imgel.src;
      return img;
    },
    // }}}
    // imageClone: function(imgel){{{
    imageClone: function(imgel){
      return $.Jcrop.supportsCanvas?
        Jcrop.canvasClone(imgel):
        Jcrop.imgCopy(imgel);
    },
    // }}}
    // canvasClone: function(imgel){{{
    canvasClone: function(imgel){
      var canvas = document.createElement('canvas'),
          ctx = canvas.getContext('2d');

      $(canvas).width(imgel.width).height(imgel.height),
      canvas.width = imgel.naturalWidth;
      canvas.height = imgel.naturalHeight;
      ctx.drawImage(imgel,0,0,imgel.naturalWidth,imgel.naturalHeight);
      return canvas;
    },
    // }}}
    // propagate: function(plist,config,obj){{{
    propagate: function(plist,config,obj){
      for(var i=0,l=plist.length;i<l;i++)
        if (config.hasOwnProperty(plist[i]))
          obj[plist[i]] = config[plist[i]];
    },
    // }}}
    // getLargestBox: function(ratio,w,h){{{
    getLargestBox: function(ratio,w,h){
      if ((w/h) > ratio)
        return [ h * ratio, h ];
          else return [ w, w / ratio ];
    },
    // }}}
    // stageConstructor: function(el,options,callback){{{
    stageConstructor: function(el,options,callback){

      // Get a priority-ordered list of available stages
      var stages = [];
      $.each(Jcrop.stage,function(i,e){
        stages.push(e);
      });
      stages.sort(function(a,b){ return a.priority - b.priority; });

      // Find the first one that supports this element
      for(var i=0,l=stages.length;i<l;i++){
        if (stages[i].isSupported(el,options)){
          stages[i].create(el,options,function(obj,opt){
            if (typeof callback == 'function') callback(obj,opt);
          });
          break;
        }
      }
    },
    // }}}
    // supportsColorFade: function(){{{
    supportsColorFade: function(){
      return $.fx.step.hasOwnProperty('backgroundColor');
    },
    // }}}
    // wrapFromXywh: function(xywh){{{
    wrapFromXywh: function(xywh){
      var b = { x: xywh[0], y: xywh[1], w: xywh[2], h: xywh[3] };
      b.x2 = b.x + b.w;
      b.y2 = b.y + b.h;
      return b;
    }
    // }}}
  });

var AbstractStage = function(){
};

$.extend(AbstractStage,{
  isSupported: function(el,o){
    // @todo: should actually check if it's an HTML element
    return true;
  },
  // A higher priority means less desirable
  // AbstractStage is the last one we want to use
  priority: 100,
  create: function(el,options,callback){
    var obj = new AbstractStage;
    obj.element = el;
    callback.call(this,obj,options);
  },
  prototype: {
    attach: function(core){
      this.init(core);
      core.ui.stage = this;
    },
    triggerEvent: function(ev){
      $(this.element).trigger(ev);
      return this;
    },
    getElement: function(){
      return this.element;
    }
  }
});
Jcrop.registerStageType('Block',AbstractStage);


var ImageStage = function(){
};

ImageStage.prototype = new AbstractStage();

$.extend(ImageStage,{
  isSupported: function(el,o){
    if (el.tagName == 'IMG') return true;
  },
  priority: 90,
  create: function(el,options,callback){
    $.Jcrop.component.ImageLoader.attach(el,function(w,h){
      var obj = new ImageStage;
      obj.element = $(el).wrap('<div />').parent();

      obj.element.width(w).height(h);
      obj.imgsrc = el;

      if (typeof callback == 'function')
        callback.call(this,obj,options);
    });
  }
});
Jcrop.registerStageType('Image',ImageStage);


var CanvasStage = function(){
  this.angle = 0;
  this.scale = 1;
  this.scaleMin = 0.2;
  this.scaleMax = 1.25;
  this.offset = [0,0];
};

CanvasStage.prototype = new ImageStage();

$.extend(CanvasStage,{
  isSupported: function(el,o){
    if ($.Jcrop.supportsCanvas && (el.tagName == 'IMG')) return true;
  },
  priority: 60,
  create: function(el,options,callback){
    var $el = $(el);
    var opt = $.extend({},options);
    $.Jcrop.component.ImageLoader.attach(el,function(w,h){
      var obj = new CanvasStage;
      $el.hide();
      obj.createCanvas(el,w,h);
      $el.before(obj.element);
      obj.imgsrc = el;
      opt.imgsrc = el;

      if (typeof callback == 'function'){
        callback(obj,opt);
        obj.redraw();
      }
    });
  }
});

$.extend(CanvasStage.prototype,{
  init: function(core){
    this.core = core;
  },
  // setOffset: function(x,y) {{{
  setOffset: function(x,y) {
    this.offset = [x,y];
    return this;
  },
  // }}}
  // setAngle: function(v) {{{
  setAngle: function(v) {
    this.angle = v;
    return this;
  },
  // }}}
  // setScale: function(v) {{{
  setScale: function(v) {
    this.scale = this.boundScale(v);
    return this;
  },
  // }}}
  boundScale: function(v){
    if (v<this.scaleMin) v = this.scaleMin;
    else if (v>this.scaleMax) v = this.scaleMax;
    return v;
  },
  createCanvas: function(img,w,h){
    this.width = w;
    this.height = h;
    this.canvas = document.createElement('canvas');
    this.canvas.width = w;
    this.canvas.height = h;
    this.$canvas = $(this.canvas).width('100%').height('100%');
    this.context = this.canvas.getContext('2d');
    this.fillstyle = "rgb(0,0,0)";
    this.element = this.$canvas.wrap('<div />').parent().width(w).height(h);
  },
  triggerEvent: function(ev){
    this.$canvas.trigger(ev);
    return this;
  },
  // clear: function() {{{
  clear: function() {
    this.context.fillStyle = this.fillstyle;
    this.context.fillRect(0, 0, this.canvas.width, this.canvas.height);
    return this;
  },
  // }}}
  // redraw: function() {{{
  redraw: function() {
    // Save the current context
    this.context.save();
    this.clear();

    // Translate to the center point of our image
    this.context.translate(parseInt(this.width * 0.5), parseInt(this.height * 0.5));
    // Perform the rotation and scaling
    this.context.translate(this.offset[0]/this.core.opt.xscale,this.offset[1]/this.core.opt.yscale);
    this.context.rotate(this.angle * (Math.PI/180));
    this.context.scale(this.scale,this.scale);
    // Translate back to the top left of our image
    this.context.translate(-parseInt(this.width * 0.5), -parseInt(this.height * 0.5));
    // Finally we draw the image
    this.context.drawImage(this.imgsrc,0,0,this.width,this.height);

    // And restore the updated context
    this.context.restore();
    this.$canvas.trigger('cropredraw');
    return this;
  },
  // }}}
  // setFillStyle: function(v) {{{
  setFillStyle: function(v) {
    this.fillstyle = v;
    return this;
  }
  // }}}
});

Jcrop.registerStageType('Canvas',CanvasStage);


  /**
   *  BackoffFilter
   *  move out-of-bounds selection into allowed position at same size
   */
  var BackoffFilter = function(){
    this.minw = 40;
    this.minh = 40;
    this.maxw = 0;
    this.maxh = 0;
    this.core = null;
  };
  $.extend(BackoffFilter.prototype,{
    tag: 'backoff',
    priority: 22,
    filter: function(b){
      var r = this.bound;

      if (b.x < r.minx) { b.x = r.minx; b.x2 = b.w + b.x; }
      if (b.y < r.miny) { b.y = r.miny; b.y2 = b.h + b.y; }
      if (b.x2 > r.maxx) { b.x2 = r.maxx; b.x = b.x2 - b.w; }
      if (b.y2 > r.maxy) { b.y2 = r.maxy; b.y = b.y2 - b.h; }

      return b;
    },
    refresh: function(sel){
      this.elw = sel.core.container.width();
      this.elh = sel.core.container.height();
      this.bound = {
        minx: 0 + sel.edge.w,
        miny: 0 + sel.edge.n,
        maxx: this.elw + sel.edge.e,
        maxy: this.elh + sel.edge.s
      };
    }
  });
  Jcrop.registerFilter('backoff',BackoffFilter);

  /**
   *  ConstrainFilter
   *  a filter to constrain crop selection to bounding element
   */
  var ConstrainFilter = function(){
    this.core = null;
  };
  $.extend(ConstrainFilter.prototype,{
    tag: 'constrain',
    priority: 5,
    filter: function(b,ord){
      if (ord == 'move') {
        if (b.x < this.minx) { b.x = this.minx; b.x2 = b.w + b.x; }
        if (b.y < this.miny) { b.y = this.miny; b.y2 = b.h + b.y; }
        if (b.x2 > this.maxx) { b.x2 = this.maxx; b.x = b.x2 - b.w; }
        if (b.y2 > this.maxy) { b.y2 = this.maxy; b.y = b.y2 - b.h; }
      } else {
        if (b.x < this.minx) { b.x = this.minx; }
        if (b.y < this.miny) { b.y = this.miny; }
        if (b.x2 > this.maxx) { b.x2 = this.maxx; }
        if (b.y2 > this.maxy) { b.y2 = this.maxy; }
      }
      b.w = b.x2 - b.x;
      b.h = b.y2 - b.y;
      return b;
    },
    refresh: function(sel){
      this.elw = sel.core.container.width();
      this.elh = sel.core.container.height();
      this.minx = 0 + sel.edge.w;
      this.miny = 0 + sel.edge.n;
      this.maxx = this.elw + sel.edge.e;
      this.maxy = this.elh + sel.edge.s;
    }
  });
  Jcrop.registerFilter('constrain',ConstrainFilter);

  /**
   *  ExtentFilter
   *  a filter to implement minimum or maximum size
   */
  var ExtentFilter = function(){
    this.core = null;
  };
  $.extend(ExtentFilter.prototype,{
    tag: 'extent',
    priority: 12,
    offsetFromCorner: function(corner,box,b){
      var w = box[0], h = box[1];
      switch(corner){
        case 'bl': return [ b.x2 - w, b.y, w, h ];
        case 'tl': return [ b.x2 - w , b.y2 - h, w, h ];
        case 'br': return [ b.x, b.y, w, h ];
        case 'tr': return [ b.x, b.y2 - h, w, h ];
      }
    },
    getQuadrant: function(s){
      var relx = s.opposite[0]-s.offsetx
      var rely = s.opposite[1]-s.offsety;

      if ((relx < 0) && (rely < 0)) return 'br';
        else if ((relx >= 0) && (rely >= 0)) return 'tl';
        else if ((relx < 0) && (rely >= 0)) return 'tr';
        return 'bl';
    },
    filter: function(b,ord,sel){

      if (ord == 'move') return b;

      var w = b.w, h = b.h, st = sel.state, r = this.limits;
      var quad = st? this.getQuadrant(st): 'br';

      if (r.minw && (w < r.minw)) w = r.minw;
      if (r.minh && (h < r.minh)) h = r.minh;
      if (r.maxw && (w > r.maxw)) w = r.maxw;
      if (r.maxh && (h > r.maxh)) h = r.maxh;

      if ((w == b.w) && (h == b.h)) return b;

      return Jcrop.wrapFromXywh(this.offsetFromCorner(quad,[w,h],b));
    },
    refresh: function(sel){
      this.elw = sel.core.container.width();
      this.elh = sel.core.container.height();

      this.limits = {
        minw: sel.minSize[0],
        minh: sel.minSize[1],
        maxw: sel.maxSize[0],
        maxh: sel.maxSize[1]
      };
    }
  });
  Jcrop.registerFilter('extent',ExtentFilter);


  /**
   *  GridFilter
   *  a rudimentary grid effect
   */
  var GridFilter = function(){
    this.stepx = 1;
    this.stepy = 1;
    this.core = null;
  };
  $.extend(GridFilter.prototype,{
    tag: 'grid',
    priority: 19,
    filter: function(b){
      
      var n = {
        x: Math.round(b.x / this.stepx) * this.stepx,
        y: Math.round(b.y / this.stepy) * this.stepy,
        x2: Math.round(b.x2 / this.stepx) * this.stepx,
        y2: Math.round(b.y2 / this.stepy) * this.stepy
      };
      
      n.w = n.x2 - n.x;
      n.h = n.y2 - n.y;

      return n;
    }
  });
  Jcrop.registerFilter('grid',GridFilter);


  /**
   *  RatioFilter
   *  implements aspectRatio locking
   */
  var RatioFilter = function(){
    this.ratio = 0;
    this.core = null;
  };
  $.extend(RatioFilter.prototype,{
    tag: 'ratio',
    priority: 15,
    offsetFromCorner: function(corner,box,b){
      var w = box[0], h = box[1];
      switch(corner){
        case 'bl': return [ b.x2 - w, b.y, w, h ];
        case 'tl': return [ b.x2 - w , b.y2 - h, w, h ];
        case 'br': return [ b.x, b.y, w, h ];
        case 'tr': return [ b.x, b.y2 - h, w, h ];
      }
    },
    getBoundRatio: function(b,quad){
      var box = Jcrop.getLargestBox(this.ratio,b.w,b.h);
      return Jcrop.wrapFromXywh(this.offsetFromCorner(quad,box,b));
    },
    getQuadrant: function(s){
      var relx = s.opposite[0]-s.offsetx
      var rely = s.opposite[1]-s.offsety;

      if ((relx < 0) && (rely < 0)) return 'br';
        else if ((relx >= 0) && (rely >= 0)) return 'tl';
        else if ((relx < 0) && (rely >= 0)) return 'tr';
        return 'bl';
    },
    filter: function(b,ord,sel){

      if (!this.ratio) return b;

      var rt = b.w / b.h;
      var st = sel.state;

      var quad = st? this.getQuadrant(st): 'br';
      ord = ord || 'se';

      if (ord == 'move') return b;

      switch(ord) {
        case 'n':
          b.x2 = this.elw;
          b.w = b.x2 - b.x;
          quad = 'tr';
          break;
        case 's':
          b.x2 = this.elw;
          b.w = b.x2 - b.x;
          quad = 'br';
          break;
        case 'e':
          b.y2 = this.elh;
          b.h = b.y2 - b.y;
          quad = 'br';
          break;
        case 'w':
          b.y2 = this.elh;
          b.h = b.y2 - b.y;
          quad = 'bl';
          break;
      }

      return this.getBoundRatio(b,quad);
    },
    refresh: function(sel){
      this.ratio = sel.aspectRatio;
      this.elw = sel.core.container.width();
      this.elh = sel.core.container.height();
    }
  });
  Jcrop.registerFilter('ratio',RatioFilter);


  /**
   *  RoundFilter
   *  rounds coordinate values to integers
   */
  var RoundFilter = function(){
    this.core = null;
  };
  $.extend(RoundFilter.prototype,{
    tag: 'round',
    priority: 90,
    filter: function(b){
      
      var n = {
        x: Math.round(b.x),
        y: Math.round(b.y),
        x2: Math.round(b.x2),
        y2: Math.round(b.y2)
      };
      
      n.w = n.x2 - n.x;
      n.h = n.y2 - n.y;

      return n;
    }
  });
  Jcrop.registerFilter('round',RoundFilter);


  /**
   *  ShadeFilter
   *  A filter that implements div-based shading on any element
   *
   *  The shading you see is actually four semi-opaque divs
   *  positioned inside the container, around the selection
   */
  var ShadeFilter = function(opacity,color){
    this.color = color || 'black';
    this.opacity = opacity || 0.5;
    this.core = null;
    this.shades = {};
  };
  $.extend(ShadeFilter.prototype,{
    tag: 'shader',
    fade: true,
    fadeEasing: 'swing',
    fadeSpeed: 320,
    priority: 95,
    init: function(){
      var t = this;

      if (!t.attached) {
        t.visible = false;

        t.container = $('<div />').addClass(t.core.opt.css_shades)
          .prependTo(this.core.container).hide();

        t.elh = this.core.container.height();
        t.elw = this.core.container.width();

        t.shades = {
          top: t.createShade(),
          right: t.createShade(),
          left: t.createShade(),
          bottom: t.createShade()
        };

        t.attached = true;
      }
    },
    destroy: function(){
      this.container.remove();
    },
    setColor: function(color,instant){
      var t = this;

      if (color == t.color) return t;

      this.color = color;
      var colorfade = Jcrop.supportsColorFade();
      $.each(t.shades,function(u,i){
        if (!t.fade || instant || !colorfade) i.css('backgroundColor',color);
          else i.animate({backgroundColor:color},{queue:false,duration:t.fadeSpeed,easing:t.fadeEasing});
      });
      return t;
    },
    setOpacity: function(opacity,instant){
      var t = this;

      if (opacity == t.opacity) return t;

      t.opacity = opacity;
      $.each(t.shades,function(u,i){
        if (!t.fade || instant) i.css({opacity:opacity});
          else i.animate({opacity:opacity},{queue:false,duration:t.fadeSpeed,easing:t.fadeEasing});
      });
      return t;
    },
    createShade: function(){
      return $('<div />').css({
        position: 'absolute',
        backgroundColor: this.color,
        opacity: this.opacity
      }).appendTo(this.container);
    },
    refresh: function(sel){
      var m = this.core, s = this.shades;

      this.setColor(sel.bgColor?sel.bgColor:this.core.opt.bgColor);
      this.setOpacity(sel.bgOpacity?sel.bgOpacity:this.core.opt.bgOpacity);
        
      this.elh = m.container.height();
      this.elw = m.container.width();
      s.right.css('height',this.elh+'px');
      s.left.css('height',this.elh+'px');
    },
    filter: function(b,ord,sel){

      if (!sel.active) return b;

      var t = this,
        s = t.shades;
      
      s.top.css({
        left: Math.round(b.x)+'px',
        width: Math.round(b.w)+'px',
        height: Math.round(b.y)+'px'
      });
      s.bottom.css({
        top: Math.round(b.y2)+'px',
        left: Math.round(b.x)+'px',
        width: Math.round(b.w)+'px',
        height: (t.elh-Math.round(b.y2))+'px'
      });
      s.right.css({
        left: Math.round(b.x2)+'px',
        width: (t.elw-Math.round(b.x2))+'px'
      });
      s.left.css({
        width: Math.round(b.x)+'px'
      });

      if (!t.visible) {
        t.container.show();
        t.visible = true;
      }

      return b;
    }
  });
  Jcrop.registerFilter('shader',ShadeFilter);
  

  /**
   *  CanvasAnimator
   *  manages smooth cropping animation
   *
   *  This object is called internally to manage animation.
   *  An in-memory div is animated and a progress callback
   *  is used to update the selection coordinates of the
   *  visible selection in realtime.
   */
  var CanvasAnimator = function(stage){
    this.stage = stage;
    this.core = stage.core;
    this.cloneStagePosition();
  };

  CanvasAnimator.prototype = {

    cloneStagePosition: function(){
      var s = this.stage;
      this.angle = s.angle;
      this.scale = s.scale;
      this.offset = s.offset;
    },

    getElement: function(){
      var s = this.stage;

      return $('<div />')
        .css({
          position: 'absolute',
          top: s.offset[0]+'px',
          left: s.offset[1]+'px',
          width: s.angle+'px',
          height: s.scale+'px'
        });
    },

    animate: function(cb){
      var t = this;

      this.scale = this.stage.boundScale(this.scale);
      t.stage.triggerEvent('croprotstart');

      t.getElement().animate({
        top: t.offset[0]+'px',
        left: t.offset[1]+'px',
        width: t.angle+'px',
        height: t.scale+'px'
      },{
        easing: t.core.opt.animEasing,
        duration: t.core.opt.animDuration,
        complete: function(){
          t.stage.triggerEvent('croprotend');
          (typeof cb == 'function') && cb.call(this);
        },
        progress: function(anim){
          var props = {}, i, tw = anim.tweens;

          for(i=0;i<tw.length;i++){
            props[tw[i].prop] = tw[i].now; }

          t.stage.setAngle(props.width)
            .setScale(props.height)
            .setOffset(props.top,props.left)
            .redraw();
        }
      });
    }

  };
  Jcrop.stage.Canvas.prototype.getAnimator = function(){
    return new CanvasAnimator(this);
  };
  Jcrop.registerComponent('CanvasAnimator',CanvasAnimator);


  /**
   *  CropAnimator
   *  manages smooth cropping animation
   *
   *  This object is called internally to manage animation.
   *  An in-memory div is animated and a progress callback
   *  is used to update the selection coordinates of the
   *  visible selection in realtime.
   */
  // var CropAnimator = function(selection){{{
  var CropAnimator = function(selection){
    this.selection = selection;
    this.core = selection.core;
  };
  // }}}

  CropAnimator.prototype = {

    getElement: function(){
      var b = this.selection.get();

      return $('<div />')
        .css({
          position: 'absolute',
          top: b.y+'px',
          left: b.x+'px',
          width: b.w+'px',
          height: b.h+'px'
        });
    },

    animate: function(x,y,w,h,cb){
      var t = this;

      t.selection.allowResize(false);

      t.getElement().animate({
        top: y+'px',
        left: x+'px',
        width: w+'px',
        height: h+'px'
      },{
        easing: t.core.opt.animEasing,
        duration: t.core.opt.animDuration,
        complete: function(){
          t.selection.allowResize(true);
          cb && cb.call(this);
        },
        progress: function(anim){
          var props = {}, i, tw = anim.tweens;

          for(i=0;i<tw.length;i++){
            props[tw[i].prop] = tw[i].now; }

          var b = {
            x: parseInt(props.left),
            y: parseInt(props.top),
            w: parseInt(props.width),
            h: parseInt(props.height)
          };

          b.x2 = b.x + b.w;
          b.y2 = b.y + b.h;

          t.selection.updateRaw(b,'se');
        }
      });
    }

  };
  Jcrop.registerComponent('Animator',CropAnimator);


  /**
   *  DragState
   *  an object that handles dragging events
   *
   *  This object is used by the built-in selection object to
   *  track a dragging operation on a selection
   */
  // var DragState = function(e,selection,ord){{{
  var DragState = function(e,selection,ord){
    var t = this;

    t.x = e.pageX;
    t.y = e.pageY;

    t.selection = selection;
    t.eventTarget = selection.core.opt.dragEventTarget;
    t.orig = selection.get();

    selection.callFilterFunction('refresh');

    var p = selection.core.container.position();
    t.elx = p.left;
    t.ely = p.top;

    t.offsetx = 0;
    t.offsety = 0;
    t.ord = ord;
    t.opposite = t.getOppositeCornerOffset();

    t.initEvents(e);

  };
  // }}}

  DragState.prototype = {
    // getOppositeCornerOffset: function(){{{
    // Calculate relative offset of locked corner
    getOppositeCornerOffset: function(){

      var o = this.orig;
      var relx = this.x - this.elx - o.x;
      var rely = this.y - this.ely - o.y;

      switch(this.ord){
        case 'nw':
        case 'w':
          return [ o.w - relx, o.h - rely ];
          return [ o.x + o.w, o.y + o.h ];

        case 'sw':
          return [ o.w - relx, -rely ];
          return [ o.x + o.w, o.y ];

        case 'se':
        case 's':
        case 'e':
          return [ -relx, -rely ];
          return [ o.x, o.y ];

        case 'ne':
        case 'n':
          return [ -relx, o.h - rely ];
          return [ o.w, o.y + o.h ];
      }

      return [ null, null ];
    },
    // }}}
    // initEvents: function(e){{{
    initEvents: function(e){
      $(this.eventTarget)
        .on('mousemove.jcrop',this.createDragHandler())
        .on('mouseup.jcrop',this.createStopHandler());
    },
    // }}}
    // dragEvent: function(e){{{
    dragEvent: function(e){
      this.offsetx = e.pageX - this.x;
      this.offsety = e.pageY - this.y;
      this.selection.updateRaw(this.getBox(),this.ord);
    },
    // }}}
    // endDragEvent: function(e){{{
    endDragEvent: function(e){
      var sel = this.selection;
      sel.core.container.removeClass('jcrop-dragging');
      sel.element.trigger('cropend',[sel,sel.core.unscale(sel.get())]);
      sel.focus();
    },
    // }}}
    // createStopHandler: function(){{{
    createStopHandler: function(){
      var t = this;
      return function(e){
        $(t.eventTarget).off('.jcrop');
        t.endDragEvent(e);
        return false;
      };
    },
    // }}}
    // createDragHandler: function(){{{
    createDragHandler: function(){
      var t = this;
      return function(e){
        t.dragEvent(e);
        return false;
      };
    },
    // }}}
    //update: function(x,y){{{
    update: function(x,y){
      var t = this;
      t.offsetx = x - t.x;
      t.offsety = y - t.y;
    },
    //}}}
    //resultWrap: function(d){{{
    resultWrap: function(d){
      var b = {
          x: Math.min(d[0],d[2]),
          y: Math.min(d[1],d[3]),
          x2: Math.max(d[0],d[2]),
          y2: Math.max(d[1],d[3])
        };

      b.w = b.x2 - b.x;
      b.h = b.y2 - b.y;

      return b;
    },
    //}}}
    //getBox: function(){{{
    getBox: function(){
      var t = this;
      var o = t.orig;
      var _c = { x2: o.x + o.w, y2: o.y + o.h };
      switch(t.ord){
        case 'n': return t.resultWrap([ o.x, t.offsety + o.y, _c.x2, _c.y2 ]);
        case 's': return t.resultWrap([ o.x, o.y, _c.x2, t.offsety + _c.y2 ]);
        case 'e': return t.resultWrap([ o.x, o.y, t.offsetx + _c.x2, _c.y2 ]);
        case 'w': return t.resultWrap([ o.x + t.offsetx, o.y, _c.x2, _c.y2 ]);
        case 'sw': return t.resultWrap([ t.offsetx + o.x, o.y, _c.x2, t.offsety + _c.y2 ]);
        case 'se': return t.resultWrap([ o.x, o.y, t.offsetx + _c.x2, t.offsety + _c.y2 ]);
        case 'ne': return t.resultWrap([ o.x, t.offsety + o.y, t.offsetx + _c.x2, _c.y2 ]);
        case 'nw': return t.resultWrap([ t.offsetx + o.x, t.offsety + o.y, _c.x2, _c.y2 ]);
        case 'move':
          _c.nx = o.x + t.offsetx;
          _c.ny = o.y + t.offsety;
          return t.resultWrap([ _c.nx, _c.ny, _c.nx + o.w, _c.ny + o.h ]);
      }
    }
    //}}}
  };
  Jcrop.registerComponent('DragState',DragState);


  /**
   *  EventManager
   *  provides internal event support
   */
  var EventManager = function(core){
    this.core = core;
  };
  EventManager.prototype = {
      on: function(n,cb){ $(this).on(n,cb); },
      off: function(n){ $(this).off(n); },
      trigger: function(n){ $(this).trigger(n); }
  };
  Jcrop.registerComponent('EventManager',EventManager);


  /**
   * Image Loader
   * Reliably pre-loads images
   */
  // var ImageLoader = function(src,element,cb){{{
  var ImageLoader = function(src,element,cb){
    this.src = src;
    if (!element) element = new Image;
    this.element = element;
    this.callback = cb;
    this.load();
  };
  // }}}

  $.extend(ImageLoader,{
    // attach: function(el,cb){{{
    attach: function(el,cb){
      return new ImageLoader(el.src,el,cb);
    },
    // }}}
    // prototype: {{{
    prototype: {
      getDimensions: function(){
        var el = this.element;

        if (el.naturalWidth)
          return [ el.naturalWidth, el. naturalHeight ];

        if (el.width)
          return [ el.width, el.height ];

        return null;
      },
      fireCallback: function(){
        this.element.onload = null;
        if (typeof this.callback == 'function')
          this.callback.apply(this,this.getDimensions());
      },
      isLoaded: function(){
        return this.element.complete;
      },
      load: function(){
        var t = this;
        var el = t.element;

        el.src = t.src;

        if (t.isLoaded()) t.fireCallback();
          else t.element.onload = function(e){
            t.fireCallback();
          };
      }
    }
    // }}}
  });
  Jcrop.registerComponent('ImageLoader',ImageLoader);


  /**
   * JcropTouch
   * Detects and enables mobile touch support
   */
  // var JcropTouch = function(core){{{
  var JcropTouch = function(core){
    this.core = core;
    this.init();
  };
  // }}}

  $.extend(JcropTouch,{
    // support: function(){{{
    support: function(){
      if(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch)
        return true;
    },
    // }}}
    prototype: {
      // init: function(){{{
      init: function(){
        var t = this,
          p = $.Jcrop.component.DragState.prototype;

        // A bit of an ugly hack to make sure we modify prototype
        // only once, store a key on the prototype
        if (!p.touch) {
          t.initEvents();
          t.shimDragState();
          t.shimStageDrag();
          p.touch = true;
        }
      },
      // }}}
      // shimDragState: function(){{{
      shimDragState: function(){
        var t = this;
        $.Jcrop.component.DragState.prototype.initEvents = function(e){
          
          // Attach subsequent drag event handlers based on initial
          // event type - avoids collecting "pseudo-mouse" events
          // generated by some mobile browsers in some circumstances
          if (e.type.substr(0,5) == 'touch') {

            $(this.eventTarget)
              .on('touchmove.jcrop.jcrop-touch',t.dragWrap(this.createDragHandler()))
              .on('touchend.jcrop.jcrop-touch',this.createStopHandler());

          }
          
          // For other events, use the mouse handlers that
          // the default DragState.initEvents() method sets...
          else {

            $(this.eventTarget)
              .on('mousemove.jcrop',this.createDragHandler())
              .on('mouseup.jcrop',this.createStopHandler());

          }

        };
      },
      // }}}
      // shimStageDrag: function(){{{
      shimStageDrag: function(){
        this.core.container
          .addClass('jcrop-touch')
          .on('touchstart.jcrop.jcrop-stage',this.dragWrap(this.core.ui.manager.startDragHandler()));
      },
      // }}}
      // dragWrap: function(cb){{{
      dragWrap: function(cb){
        return function(e){
          e.preventDefault();
          e.stopPropagation();
          if (e.type.substr(0,5) == 'touch') {
            e.pageX = e.originalEvent.changedTouches[0].pageX;
            e.pageY = e.originalEvent.changedTouches[0].pageY;
            return cb(e);
          }
          return false;
        };
      },
      // }}}
      // initEvents: function(){{{
      initEvents: function(){
        var t = this, c = t.core;

        c.container.on(
          'touchstart.jcrop.jcrop-touch',
          '.'+c.opt.css_drag,
          t.dragWrap(c.startDrag())
        );
      }
      // }}}
    }
  });
  Jcrop.registerComponent('Touch',JcropTouch);


  /**
   *  KeyWatcher
   *  provides keyboard support
   */
  // var KeyWatcher = function(core){{{
  var KeyWatcher = function(core){
    this.core = core;
    this.init();
  };
  // }}}
  $.extend(KeyWatcher,{
    // defaults: {{{
    defaults: {
      eventName: 'keydown.jcrop',
      passthru: [ 9 ],
      debug: false
    },
    // }}}
    prototype: {
      // init: function(){{{
      init: function(){
        $.extend(this,KeyWatcher.defaults);
        this.enable();
      },
      // }}}
      // disable: function(){{{
      disable: function(){
        this.core.container.off(this.eventName);
      },
      // }}}
      // enable: function(){{{
      enable: function(){
        var t = this, m = t.core;
        m.container.on(t.eventName,function(e){
          var nudge = e.shiftKey? 16: 2;

          if ($.inArray(e.keyCode,t.passthru) >= 0)
            return true;

          switch(e.keyCode){
            case 37: m.nudge(-nudge,0); break;
            case 38: m.nudge(0,-nudge); break;
            case 39: m.nudge(nudge,0); break;
            case 40: m.nudge(0,nudge); break;

            case 46:
            case 8:
              m.requestDelete();
              return false;
              break;

            default:
              if (t.debug) console.log('keycode: ' + e.keyCode);
              break;
          }

          if (!e.metaKey && !e.ctrlKey)
            e.preventDefault();
        });
      }
      // }}}
    }
  });
  Jcrop.registerComponent('Keyboard',KeyWatcher);


  /**
   * Selection
   * Built-in selection object
   */
  var Selection = function(){};

  $.extend(Selection,{
    // defaults: {{{
    defaults: {
      minSize: [ 8, 8 ],
      maxSize: [ 0, 0 ],
      aspectRatio: 0,
      edge: { n: 0, s: 0, e: 0, w: 0 },
      bgColor: null,
      bgOpacity: null,
      last: null,

      state: null,
      active: true,
      linked: true,
      canDelete: true,
      canDrag: true,
      canResize: true,
      canSelect: true
    },
    // }}}
    prototype: {
      // init: function(core){{{
      init: function(core){
        this.core = core;
        this.startup();
        this.linked = this.core.opt.linked;
        this.attach();
        this.setOptions(this.core.opt);
        core.container.trigger('cropcreate',[this]);
      },
      // }}}
      // attach: function(){{{
      attach: function(){
        // For extending init() sequence
      },
      // }}}
      // startup: function(){{{
      startup: function(){
        var t = this, o = t.core.opt;
        $.extend(t,Selection.defaults);
        t.filter = t.core.getDefaultFilters();

        t.element = $('<div />').addClass(o.css_selection).data({ selection: t });
        t.frame = $('<button />').addClass(o.css_button).data('ord','move').attr('type','button');
        t.element.append(t.frame).appendTo(t.core.container);

        // IE background/draggable hack
        if (t.core.opt.is_msie) t.frame.css({
          opacity: 0,
          backgroundColor: 'white'
        });

        t.insertElements();

        // Bind focus and blur events for this selection
        t.frame.on('focus.jcrop',function(e){
          t.core.setSelection(t);
          t.element.trigger('cropfocus',t);
          t.element.addClass('jcrop-focus');
        }).on('blur.jcrop',function(e){
          t.element.removeClass('jcrop-focus');
          t.element.trigger('cropblur',t);
        });
      },
      // }}}
      // propagate: [{{{
      propagate: [
        'canDelete', 'canDrag', 'canResize', 'canSelect',
        'minSize', 'maxSize', 'aspectRatio', 'edge'
      ],
      // }}}
      // setOptions: function(opt){{{
      setOptions: function(opt){
        Jcrop.propagate(this.propagate,opt,this);
        this.refresh();
        return this;
      },
      // }}}
      // refresh: function(){{{
      refresh: function(){
        this.allowResize();
        this.allowDrag();
        this.allowSelect();
        this.callFilterFunction('refresh');
        this.updateRaw(this.get(),'se');
      },
      // }}}
      // callFilterFunction: function(f,args){{{
      callFilterFunction: function(f,args){
        for(var i=0;i<this.filter.length;i++)
          if (this.filter[i][f]) this.filter[i][f](this);
        return this;
      },
      // }}}
      //addFilter: function(filter){{{
      addFilter: function(filter){
        filter.core = this.core;
        if (!this.hasFilter(filter)) {
          this.filter.push(filter);
          this.sortFilters();
          if (filter.init) filter.init();
          this.refresh();
        }
      },
      //}}}
      // hasFilter: function(filter){{{
      hasFilter: function(filter){
        var i, f = this.filter, n = [];
        for(i=0;i<f.length;i++) if (f[i] === filter) return true;
      },
      // }}}
      // sortFilters: function(){{{
      sortFilters: function(){
        this.filter.sort(
          function(x,y){ return x.priority - y.priority; }
        );
      },
      // }}}
      //clearFilters: function(){{{
      clearFilters: function(){
        var i, f = this.filter;

        for(var i=0;i<f.length;i++)
          if (f[i].destroy) f[i].destroy();

        this.filter = [];
      },
      //}}}
      // removeFiltersByTag: function(tag){{{
      removeFilter: function(tag){
        var i, f = this.filter, n = [];

        for(var i=0;i<f.length;i++)
          if ((f[i].tag && (f[i].tag == tag)) || (tag === f[i])){
            if (f[i].destroy) f[i].destroy();
          }
          else n.push(f[i]);

        this.filter = n;
      },
      // }}}
      // runFilters: function(b,ord){{{
      runFilters: function(b,ord){
        for(var i=0;i<this.filter.length;i++)
          b = this.filter[i].filter(b,ord,this);
        return b;
      },
      // }}}
      //endDrag: function(){{{
      endDrag: function(){
        if (this.state) {
          $(document.body).off('.jcrop');
          this.focus();
          this.state = null;
        }
      },
      //}}}
      // startDrag: function(e,ord){{{
      startDrag: function(e,ord){
        var t = this;
        var m = t.core;

        ord = ord || $(e.target).data('ord');

        this.focus();

        if ((ord == 'move') && t.element.hasClass(t.core.opt.css_nodrag))
          return false;

        this.state = new Jcrop.component.DragState(e,this,ord);
        return false;
      },
      // }}}
      // allowSelect: function(v){{{
      allowSelect: function(v){
        if (v === undefined) v = this.canSelect;

        if (v && this.canSelect) this.frame.attr('disabled',false);
          else this.frame.attr('disabled','disabled');

        return this;
      },
      // }}}
      // allowDrag: function(v){{{
      allowDrag: function(v){
        var t = this, o = t.core.opt;
        if (v == undefined) v = t.canDrag;

        if (v && t.canDrag) t.element.removeClass(o.css_nodrag);
          else t.element.addClass(o.css_nodrag);

        return this;
      },
      // }}}
      // allowResize: function(v){{{
      allowResize: function(v){
        var t = this, o = t.core.opt;
        if (v == undefined) v = t.canResize;

        if (v && t.canResize) t.element.removeClass(o.css_noresize);
          else t.element.addClass(o.css_noresize);

        return this;
      },
      // }}}
      // remove: function(){{{
      remove: function(){
        this.element.trigger('cropremove',this);
        this.element.remove();
      },
      // }}}
      // toBack: function(){{{
      toBack: function(){
        this.active = false;
        this.element.removeClass('jcrop-current jcrop-focus');
      },
      // }}}
      // toFront: function(){{{
      toFront: function(){
        this.active = true;
        this.element.addClass('jcrop-current');
        this.callFilterFunction('refresh');
        this.refresh();
      },
      // }}}
      // redraw: function(b){{{
      redraw: function(b){
        this.moveTo(b.x,b.y);
        this.resize(b.w,b.h);
        this.last = b;
        return this;
      },
      // }}}
      // update: function(b,ord){{{
      update: function(b,ord){
        return this.updateRaw(this.core.scale(b),ord);
      },
      // }}}
      // update: function(b,ord){{{
      updateRaw: function(b,ord){
        b = this.runFilters(b,ord);
        this.redraw(b);
        this.element.trigger('cropmove',[this,this.core.unscale(b)]);
        return this;
      },
      // }}}
      // animateTo: function(box,cb){{{
      animateTo: function(box,cb){
        var ca = new Jcrop.component.Animator(this),
            b = this.core.scale(Jcrop.wrapFromXywh(box));

        ca.animate(b.x,b.y,b.w,b.h,cb);
      },
      // }}}
      // center: function(instant){{{
      center: function(instant){
        var b = this.get(), m = this.core;
        var elw = m.container.width(), elh = m.container.height();
        var box = [ (elw-b.w)/2, (elh-b.h)/2, b.w, b.h ];
        return this[instant?'setSelect':'animateTo'](box);
      },
      // }}}
      //createElement: function(type,ord){{{
      createElement: function(type,ord){
        return $('<div />').addClass(type+' ord-'+ord).data('ord',ord);
      },
      //}}}
      //moveTo: function(x,y){{{
      moveTo: function(x,y){
        this.element.css({top: y+'px', left: x+'px'});
      },
      //}}}
      // blur: function(){{{
      blur: function(){
        this.element.blur();
        return this;
      },
      // }}}
      // focus: function(){{{
      focus: function(){
        this.core.setSelection(this);
        this.frame.focus();
        return this;
      },
      // }}}
      //resize: function(w,h){{{
      resize: function(w,h){
        this.element.css({width: w+'px', height: h+'px'});
      },
      //}}}
      //get: function(){{{
      get: function(){
        var b = this.element,
          o = b.position(),
          w = b.width(),
          h = b.height(),
          rv = { x: o.left, y: o.top };

        rv.x2 = rv.x + w;
        rv.y2 = rv.y + h;
        rv.w = w;
        rv.h = h;

        return rv;
      },
      //}}}
      //insertElements: function(){{{
      insertElements: function(){
        var t = this, i,
          m = t.core,
          fr = t.element,
          o = t.core.opt,
          b = o.borders,
          h = o.handles,
          d = o.dragbars;

        for(i=0; i<d.length; i++)
          fr.append(t.createElement(o.css_dragbars,d[i]));

        for(i=0; i<h.length; i++)
          fr.append(t.createElement(o.css_handles,h[i]));

        for(i=0; i<b.length; i++)
          fr.append(t.createElement(o.css_borders,b[i]));
      }
      //}}}
    }
  });
  Jcrop.registerComponent('Selection',Selection);


  /**
   * StageDrag
   * Facilitates dragging
   */
  // var StageDrag = function(manager,opt){{{
  var StageDrag = function(manager,opt){
    $.extend(this,StageDrag.defaults,opt || {});
    this.manager = manager;
    this.core = manager.core;
  };
  // }}}
  // StageDrag.defaults = {{{
  StageDrag.defaults = {
    offset: [ -8, -8 ],
    active: true,
    minsize: [ 20, 20 ]
  };
  // }}}

  $.extend(StageDrag.prototype,{
    // start: function(e){{{
    start: function(e){
      var c = this.core;

      // Do nothing if allowSelect is off
      if (!c.opt.allowSelect) return;

      // Also do nothing if we can't draw any more selections
      if (c.opt.multi && c.opt.multiMax && (c.ui.multi.length >= c.opt.multiMax)) return false;

      // calculate a few variables for this drag operation
      var o = $(e.currentTarget).offset();
      var origx = e.pageX - o.left + this.offset[0];
      var origy = e.pageY - o.top + this.offset[1];
      var m = c.ui.multi;

      // Determine newly dragged crop behavior if multi disabled
      if (!c.opt.multi) {
        // For multiCleaanup true, remove all existing selections
        if (c.opt.multiCleanup){
          for(var i=0;i<m.length;i++) m[i].remove();
          c.ui.multi = [];
        }
        // If not, only remove the currently active selection
        else {
          c.removeSelection(c.ui.selection);
        }
      }

      c.container.addClass('jcrop-dragging');

      // Create the new selection
      var sel = c.newSelection()
        // and position it
        .updateRaw(Jcrop.wrapFromXywh([origx,origy,1,1]));

      sel.element.trigger('cropstart',[sel,this.core.unscale(sel.get())]);
      
      return sel.startDrag(e,'se');
    },
    // }}}
    // end: function(x,y){{{
    end: function(x,y){
      this.drag(x,y);
      var b = this.sel.get();

      this.core.container.removeClass('jcrop-dragging');

      if ((b.w < this.minsize[0]) || (b.h < this.minsize[1]))
        this.core.requestDelete();

        else this.sel.focus();
    }
    // }}}
  });
  Jcrop.registerComponent('StageDrag',StageDrag);


  /**
   * StageManager
   * Provides basic stage-specific functionality
   */
  // var StageManager = function(core){{{
  var StageManager = function(core){
    this.core = core;
    this.ui = core.ui;
    this.init();
  };
  // }}}

  $.extend(StageManager.prototype,{
    // init: function(){{{
    init: function(){
      this.setupEvents();
      this.dragger = new StageDrag(this);
    },
    // }}}
    // tellConfigUpdate: function(options){{{
    tellConfigUpdate: function(options){
      for(var i=0,m=this.ui.multi,l=m.length;i<l;i++)
        if (m[i].setOptions && (m[i].linked || (this.core.opt.linkCurrent && m[i] == this.ui.selection)))
          m[i].setOptions(options);
    },
    // }}}
    // startDragHandler: function(){{{
    startDragHandler: function(){
      var t = this;
      return function(e){
        if (!e.button || t.core.opt.is_ie_lt9) return t.dragger.start(e);
      };
    },
    // }}}
    // removeEvents: function(){{{
    removeEvents: function(){
      this.core.event.off('.jcrop-stage');
      this.core.container.off('.jcrop-stage');
    },
    // }}}
    // shimLegacyHandlers: function(options){{{
    // This method uses the legacyHandlers configuration object to
    // gracefully wrap old-style Jcrop events with new ones
    shimLegacyHandlers: function(options){
      var _x = {}, core = this.core, tmp;

      $.each(core.opt.legacyHandlers,function(k,i){
        if (k in options) {
          tmp = options[k];
          core.container.off('.jcrop-'+k)
            .on(i+'.jcrop.jcrop-'+k,function(e,s,c){
              tmp.call(core,c);
            });
          delete options[k];
        }
      });
    },
    // }}}
    // setupEvents: function(){{{
    setupEvents: function(){
      var t = this, c = t.core;

      c.event.on('configupdate.jcrop-stage',function(e){
        t.shimLegacyHandlers(c.opt);
        t.tellConfigUpdate(c.opt)
        c.container.trigger('cropconfig',[c,c.opt]);
      });

      this.core.container
        .on('mousedown.jcrop.jcrop-stage',this.startDragHandler());
    }
    // }}}
  });
  Jcrop.registerComponent('StageManager',StageManager);


  var Thumbnailer = function(){
  };

  $.extend(Thumbnailer,{
    defaults: {
      // Set to a specific Selection object
      // If this value is set, the preview will only track that Selection
      selection: null,

      fading: true,
      fadeDelay: 1000,
      fadeDuration: 1000,
      autoHide: false,
      width: 80,
      height: 80,
      _hiding: null
    },

    prototype: {
      recopyCanvas: function(){
        var s = this.core.ui.stage, cxt = s.context;
        this.context.putImageData(cxt.getImageData(0,0,s.canvas.width,s.canvas.height),0,0);
      },
      init: function(core,options){
        var t = this;
        this.core = core;
        $.extend(this,Thumbnailer.defaults,options);
        t.initEvents();
        t.refresh();
        t.insertElements();
        if (t.selection) {
          t.renderSelection(t.selection);
          t.selectionTarget = t.selection.element[0];
        } else if (t.core.ui.selection) {
          t.renderSelection(t.core.ui.selection);
        }

        if (t.core.ui.stage.canvas) {
          t.context = t.preview[0].getContext('2d');
          t.core.container.on('cropredraw',function(e){
            t.recopyCanvas();
            t.refresh();
          });
        }
      },
      updateImage: function(imgel){
        this.preview.remove();
        this.preview = $($.Jcrop.imageClone(imgel));
        this.element.append(this.preview);
        this.refresh();
        return this;
      },
      insertElements: function(){
        this.preview = $($.Jcrop.imageClone(this.core.ui.stage.imgsrc));

        this.element = $('<div />').addClass('jcrop-thumb')
          .width(this.width).height(this.height)
          .append(this.preview)
          .appendTo(this.core.container);
      },
      resize: function(w,h){
        this.width = w;
        this.height = h;
        this.element.width(w).height(h);
        this.renderCoords(this.last);
      },
      refresh: function(){
        this.cw = (this.core.opt.xscale * this.core.container.width());
        this.ch = (this.core.opt.yscale * this.core.container.height());
        if (this.last) {
          this.renderCoords(this.last);
        }
      },
      renderCoords: function(c){
        var rx = this.width / c.w;
        var ry = this.height / c.h;

        this.preview.css({
          width: Math.round(rx * this.cw) + 'px',
          height: Math.round(ry * this.ch) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });

        this.last = c;
        return this;
      },
      renderSelection: function(s){
        return this.renderCoords(s.core.unscale(s.get()));
      },
      selectionStart: function(s){
        this.renderSelection(s);
      },
      show: function(){
        if (this._hiding) clearTimeout(this._hiding);

        if (!this.fading) this.element.stop().css({ opacity: 1 });
        else this.element.stop().animate({ opacity: 1 },{ duration: 80, queue: false });
      },
      hide: function(){
        var t = this;
        if (!t.fading) t.element.hide();
        else t._hiding = setTimeout(function(){
          t._hiding = null;
          t.element.stop().animate({ opacity: 0 },{ duration: t.fadeDuration, queue: false });
        },t.fadeDelay);
      },
      initEvents: function(){
        var t = this;
        t.core.container.on('croprotstart croprotend cropimage cropstart cropmove cropend',function(e,s,c){
          if (t.selectionTarget && (t.selectionTarget !== e.target)) return false;

          switch(e.type){

            case 'cropimage':
              t.updateImage(c);
              break;

            case 'cropstart':
              t.selectionStart(s);
            case 'croprotstart':
              t.show();
              break;

            case 'cropend':
              t.renderCoords(c);
            case 'croprotend':
              if (t.autoHide) t.hide();
              break;

            case 'cropmove':
              t.renderCoords(c);
              break;
          }
        });
      }
    }
  });
  Jcrop.registerComponent('Thumbnailer',Thumbnailer);


  /**
   * DialDrag component
   * This is a little hacky, it was adapted from some previous/old code
   * Plan to update this API in the future
   */
  var DialDrag = function() { };

  DialDrag.prototype = {

    init: function(core,actuator,callback){
      var that = this;

      if (!actuator) actuator = core.container;
      this.$btn = $(actuator);
      this.$targ = $(actuator);
      this.core = core;

      this.$btn
        .addClass('dialdrag')
        .on('mousedown.dialdrag',this.mousedown())
        .data('dialdrag',this);

      if (!$.isFunction(callback)) callback = function(){ };
      this.callback = callback;
      this.ondone = callback;
    },

    remove: function(){
      this.$btn
        .removeClass('dialdrag')
        .off('.dialdrag')
        .data('dialdrag',null);
      return this;
    },

    setTarget: function(obj){
      this.$targ = $(obj);
      return this;
    },

    getOffset: function(){
      var targ = this.$targ, pos = targ.offset();
      return [
        pos.left + (targ.width()/2),
        pos.top + (targ.height()/2)
      ];
    },

    relMouse: function(e){
      var x = e.pageX - this.offset[0],
          y = e.pageY - this.offset[1],
          ang = Math.atan2(y,x) * (180 / Math.PI),
          vec = Math.sqrt(Math.pow(x,2)+Math.pow(y,2));
      return [ x, y, ang, vec ];
    },

    mousedown: function(){
      var that = this;

      function mouseUp(e){
        $(window).off('.dialdrag');
        that.ondone.call(that,that.relMouse(e));
        that.core.container.trigger('croprotend');
      }

      function mouseMove(e){
        that.callback.call(that,that.relMouse(e));
      }

      return function(e) {
        that.offset = that.getOffset();
        var rel = that.relMouse(e);
        that.angleOffset = -that.core.ui.stage.angle+rel[2];
        that.distOffset = rel[3];
        that.dragOffset = [rel[0],rel[1]];
        that.core.container.trigger('croprotstart');

        $(window)
          .on('mousemove.dialdrag',mouseMove)
          .on('mouseup.dialdrag',mouseUp);

        that.callback.call(that,that.relMouse(e));

        return false;
      };
    }
    
  };
  Jcrop.registerComponent('DialDrag',DialDrag);


    /////////////////////////////////
    // DEFAULT SETTINGS

    Jcrop.defaults = {

      // Selection Behavior
      edge: { n: 0, s: 0, e: 0, w: 0 },
      setSelect: null,
      linked: true,
      linkCurrent: true,
      canDelete: true,
      canSelect: true,
      canDrag: true,
      canResize: true,

      // Component constructors
      eventManagerComponent:  Jcrop.component.EventManager,
      keyboardComponent:      Jcrop.component.Keyboard,
      dragstateComponent:     Jcrop.component.DragState,
      stagemanagerComponent:  Jcrop.component.StageManager,
      animatorComponent:      Jcrop.component.Animator,
      selectionComponent:     Jcrop.component.Selection,

      // This is a function that is called, which returns a stage object
      stageConstructor:       Jcrop.stageConstructor,

      // Stage Behavior
      allowSelect: true,
      multi: false,
      multiMax: false,
      multiCleanup: true,
      animation: true,
      animEasing: 'swing',
      animDuration: 400,
      fading: true,
      fadeDuration: 300,
      fadeEasing: 'swing',
      bgColor: 'black',
      bgOpacity: .5,

      // Startup options
      applyFilters: [ 'constrain', 'extent', 'backoff', 'ratio', 'shader', 'round' ],
      borders:  [ 'e', 'w', 's', 'n' ],
      handles:  [ 'n', 's', 'e', 'w', 'sw', 'ne', 'nw', 'se' ],
      dragbars: [ 'n', 'e', 'w', 's' ],

      dragEventTarget: window,

      xscale: 1,
      yscale: 1,

      boxWidth: null,
      boxHeight: null,

      // CSS Classes
      // @todo: These need to be moved to top-level object keys
      // for better customization. Currently if you try to extend one
      // via an options object to Jcrop, it will wipe out all
      // the others you don't specify. Be careful for now!
      css_nodrag: 'jcrop-nodrag',
      css_drag: 'jcrop-drag',
      css_container: 'jcrop-active',
      css_shades: 'jcrop-shades',
      css_selection: 'jcrop-selection',
      css_borders: 'jcrop-border',
      css_handles: 'jcrop-handle jcrop-drag',
      css_button: 'jcrop-box jcrop-drag',
      css_noresize: 'jcrop-noresize',
      css_dragbars: 'jcrop-dragbar jcrop-drag',

      legacyHandlers: {
        onChange: 'cropmove',
        onSelect: 'cropend'
      }

    };


  // Jcrop API methods
  $.extend(Jcrop.prototype,{
    //init: function(){{{
    init: function(){
      this.event = new this.opt.eventManagerComponent(this);
      this.ui.keyboard = new this.opt.keyboardComponent(this);
      this.ui.manager = new this.opt.stagemanagerComponent(this);
      this.applyFilters();

      if ($.Jcrop.supportsTouch)
        new $.Jcrop.component.Touch(this);

      this.initEvents();
    },
    //}}}
    // applySizeConstraints: function(){{{
    applySizeConstraints: function(){
      var o = this.opt,
          img = this.opt.imgsrc;

      if (img){

        var iw = img.naturalWidth || img.width,
            ih = img.naturalHeight || img.height,
            bw = o.boxWidth || iw,
            bh = o.boxHeight || ih;

        if (img && ((iw > bw) || (ih > bh))){
          var bx = Jcrop.getLargestBox(iw/ih,bw,bh);
          $(img).width(bx[0]).height(bx[1]);
          this.resizeContainer(bx[0],bx[1]);
          this.opt.xscale = iw / bx[0];
          this.opt.yscale = ih / bx[1];
        }
          
      }

      if (this.opt.trueSize){
        var dw = this.opt.trueSize[0];
        var dh = this.opt.trueSize[1];
        var cs = this.getContainerSize();
        this.opt.xscale = dw / cs[0];
        this.opt.yscale = dh / cs[1];
      }
    },
    // }}}
    initComponent: function(name){
      if (Jcrop.component[name]) {
        var args = Array.prototype.slice.call(arguments);
        var obj = new Jcrop.component[name];
        args.shift();
        args.unshift(this);
        obj.init.apply(obj,args);
        return obj;
      }
    },
    // setOptions: function(opt){{{
    setOptions: function(opt,proptype){

      if (!$.isPlainObject(opt)) opt = {};

      $.extend(this.opt,opt);

      // Handle a setSelect value
      if (this.opt.setSelect) {

        // If there is no current selection
        // passing setSelect will create one
        if (!this.ui.multi.length)
          this.newSelection();

        // Use these values to update the current selection
        this.setSelect(this.opt.setSelect);

        // Set to null so it doesn't get called again
        this.opt.setSelect = null;
      }

      this.event.trigger('configupdate');
      return this;
    },
    // }}}
    //destroy: function(){{{
    destroy: function(){
      if (this.opt.imgsrc) {
        this.container.before(this.opt.imgsrc);
        this.container.remove();
        $(this.opt.imgsrc).removeData('Jcrop').show();
      } else {
        // @todo: more elegant destroy() process for non-image containers
        this.container.remove();
      }
    },
    // }}}
    // applyFilters: function(){{{
    applyFilters: function(){
      var obj;
      for(var i=0,f=this.opt.applyFilters,l=f.length; i<l; i++){
        if ($.Jcrop.filter[f[i]])
          obj = new $.Jcrop.filter[f[i]];
          obj.core = this;
          if (obj.init) obj.init();
          this.filter[f[i]] = obj;
      }
    },
    // }}}
    // getDefaultFilters: function(){{{
    getDefaultFilters: function(){
      var rv = [];

      for(var i=0,f=this.opt.applyFilters,l=f.length; i<l; i++)
        if(this.filter.hasOwnProperty(f[i]))
          rv.push(this.filter[f[i]]);

      rv.sort(function(x,y){ return x.priority - y.priority; });
      return rv;
    },
    // }}}
    // setSelection: function(sel){{{
    setSelection: function(sel){
      var m = this.ui.multi;
      var n = [];
      for(var i=0;i<m.length;i++) {
        if (m[i] !== sel) n.push(m[i]);
        m[i].toBack();
      }
      n.unshift(sel);
      this.ui.multi = n;
      this.ui.selection = sel;
      sel.toFront();
      return sel;
    },
    // }}}
    // getSelection: function(raw){{{
    getSelection: function(raw){
      var b = this.ui.selection.get();
      return b;
    },
    // }}}
    // newSelection: function(){{{
    newSelection: function(sel){
      if (!sel)
        sel = new this.opt.selectionComponent();

      sel.init(this);
      this.setSelection(sel);

      return sel;
    },
    // }}}
    // hasSelection: function(sel){{{
    hasSelection: function(sel){
      for(var i=0;i<this.ui.multi;i++)
        if (sel === this.ui.multi[i]) return true;
    },
    // }}}
    // removeSelection: function(sel){{{
    removeSelection: function(sel){
      var i, n = [], m = this.ui.multi;
      for(var i=0;i<m.length;i++){
        if (sel !== m[i])
          n.push(m[i]);
        else m[i].remove();
      }
      return this.ui.multi = n;
    },
    // }}}
    //addFilter: function(filter){{{
    addFilter: function(filter){
      for(var i=0,m=this.ui.multi,l=m.length; i<l; i++)
        m[i].addFilter(filter);

      return this;
    },
    //}}}
    // removeFiltersByTag: function(tag){{{
    removeFilter: function(filter){
      for(var i=0,m=this.ui.multi,l=m.length; i<l; i++)
        m[i].removeFilter(filter);

      return this;
    },
    // }}}
    // blur: function(){{{
    blur: function(){
      this.ui.selection.blur();
      return this;
    },
    // }}}
    // focus: function(){{{
    focus: function(){
      this.ui.selection.focus();
      return this;
    },
    // }}}
    //initEvents: function(){{{
    initEvents: function(){
      var t = this;
      t.container.on('selectstart',function(e){ return false; })
        .on('mousedown','.'+t.opt.css_drag,t.startDrag());
    },
    //}}}
    // maxSelect: function(){{{
    maxSelect: function(){
      this.setSelect([0,0,this.elw,this.elh]);
    },
    // }}}
    // nudge: function(x,y){{{
    nudge: function(x,y){
      var s = this.ui.selection, b = s.get();

      b.x += x;
      b.x2 += x;
      b.y += y;
      b.y2 += y;

      if (b.x < 0) { b.x2 = b.w; b.x = 0; }
        else if (b.x2 > this.elw) { b.x2 = this.elw; b.x = b.x2 - b.w; }

      if (b.y < 0) { b.y2 = b.h; b.y = 0; }
        else if (b.y2 > this.elh) { b.y2 = this.elh; b.y = b.y2 - b.h; }
      
      s.element.trigger('cropstart',[s,this.unscale(b)]);
      s.updateRaw(b,'move');
      s.element.trigger('cropend',[s,this.unscale(b)]);
    },
    // }}}
    // refresh: function(){{{
    refresh: function(){
      for(var i=0,s=this.ui.multi,l=s.length;i<l;i++)
        s[i].refresh();
    },
    // }}}
    // blurAll: function(){{{
    blurAll: function(){
      var m = this.ui.multi;
      for(var i=0;i<m.length;i++) {
        if (m[i] !== sel) n.push(m[i]);
        m[i].toBack();
      }
    },
    // }}}
    // scale: function(b){{{
    scale: function(b){
      var xs = this.opt.xscale,
          ys = this.opt.yscale;

      return {
        x: b.x / xs,
        y: b.y / ys,
        x2: b.x2 / xs,
        y2: b.y2 / ys,
        w: b.w / xs,
        h: b.h / ys
      };
    },
    // }}}
    // unscale: function(b){{{
    unscale: function(b){
      var xs = this.opt.xscale,
          ys = this.opt.yscale;

      return {
        x: b.x * xs,
        y: b.y * ys,
        x2: b.x2 * xs,
        y2: b.y2 * ys,
        w: b.w * xs,
        h: b.h * ys
      };
    },
    // }}}
    // requestDelete: function(){{{
    requestDelete: function(){
      if ((this.ui.multi.length > 1) && (this.ui.selection.canDelete))
        return this.deleteSelection();
    },
    // }}}
    // deleteSelection: function(){{{
    deleteSelection: function(){
      if (this.ui.selection) {
        this.removeSelection(this.ui.selection);
        if (this.ui.multi.length) this.ui.multi[0].focus();
        this.ui.selection.refresh();
      }
    },
    // }}}
    // animateTo: function(box){{{
    animateTo: function(box){
      if (this.ui.selection)
        this.ui.selection.animateTo(box);
      return this;
    },
    // }}}
    // setselect: function(box){{{
    setSelect: function(box){
      if (this.ui.selection)
        this.ui.selection.update(Jcrop.wrapFromXywh(box));
      return this;
    },
    // }}}
    //startDrag: function(){{{
    startDrag: function(){
      var t = this;
      return function(e){
        var $targ = $(e.target);
        var selection = $targ.closest('.'+t.opt.css_selection).data('selection');
        var ord = $targ.data('ord');
        t.container.trigger('cropstart',[selection,t.unscale(selection.get())]);
        selection.startDrag(e,ord);
        return false;
      };
    },
    //}}}
    // getContainerSize: function(){{{
    getContainerSize: function(){
      return [ this.container.width(), this.container.height() ];
    },
    // }}}
    // resizeContainer: function(w,h){{{
    resizeContainer: function(w,h){
      this.container.width(w).height(h);
      this.refresh();
    },
    // }}}
    // setImage: function(src,cb){{{
    setImage: function(src,cb){
      var t = this, targ = t.opt.imgsrc;

      if (!targ) return false;

      new $.Jcrop.component.ImageLoader(src,null,function(w,h){
        t.resizeContainer(w,h);

        targ.src = src;
        $(targ).width(w).height(h);
        t.applySizeConstraints();
        t.refresh();
        t.container.trigger('cropimage',[t,targ]);

        if (typeof cb == 'function')
          cb.call(t,w,h);
      });
    },
    // }}}
    // update: function(b){{{
    update: function(b){
      if (this.ui.selection)
        this.ui.selection.update(b);
    }
    // }}}
    
  });

  // Jcrop jQuery plugin function
  $.fn.Jcrop = function(options,callback){
    options = options || {};

    var first = this.eq(0).data('Jcrop');
    var args = Array.prototype.slice.call(arguments);

    // Return API if requested
    if (options == 'api') { return first; }

    // Allow calling API methods (with arguments)
    else if (first && (typeof options == 'string')) {

      // Call method if it exists
      if (first[options]) {
        args.shift();
        first[options].apply(first,args);
        return first;
      }

      // Unknown input/method does not exist
      return false;
    }

    // Otherwise, loop over selected elements
    this.each(function(){
      var t = this, $t = $(this);
      var exists = $t.data('Jcrop');
      var obj;

      // If Jcrop already exists on this element only setOptions()
      if (exists)
        exists.setOptions(options);

      else {

        if (!options.stageConstructor)
          options.stageConstructor = $.Jcrop.stageConstructor;

        options.stageConstructor(this,options,function(stage,options){
          var selection = options.setSelect;
          if (selection) delete(options.setSelect);

          var obj = $.Jcrop.attach(stage.element,options);

          if (typeof stage.attach == 'function')
            stage.attach(obj);

          $t.data('Jcrop',obj);

          if (selection) {
            obj.newSelection();
            obj.setSelect(selection);
          }

          if (typeof callback == 'function')
            callback.call(obj);
        });
      }

      return this;
    });
  };

/* Modernizr 2.7.1 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-csstransforms-canvas-canvastext-draganddrop-inlinesvg-svg-svgclippaths-touch-teststyles-testprop-testallprops-hasevent-prefixes-domprefixes-url_data_uri
 */
;

var Modernizr = (function( window, document, undefined ) {

    var version = '2.7.1',

    Modernizr = {},


    docElement = document.documentElement,

    mod = 'modernizr',
    modElem = document.createElement(mod),
    mStyle = modElem.style,

    inputElem  ,


    toString = {}.toString,

    prefixes = ' -webkit- -moz- -o- -ms- '.split(' '),



    omPrefixes = 'Webkit Moz O ms',

    cssomPrefixes = omPrefixes.split(' '),

    domPrefixes = omPrefixes.toLowerCase().split(' '),

    ns = {'svg': 'http://www.w3.org/2000/svg'},

    tests = {},
    inputs = {},
    attrs = {},

    classes = [],

    slice = classes.slice,

    featureName, 


    injectElementWithStyles = function( rule, callback, nodes, testnames ) {

      var style, ret, node, docOverflow,
          div = document.createElement('div'),
                body = document.body,
                fakeBody = body || document.createElement('body');

      if ( parseInt(nodes, 10) ) {
                      while ( nodes-- ) {
              node = document.createElement('div');
              node.id = testnames ? testnames[nodes] : mod + (nodes + 1);
              div.appendChild(node);
          }
      }

                style = ['&#173;','<style id="s', mod, '">', rule, '</style>'].join('');
      div.id = mod;
          (body ? div : fakeBody).innerHTML += style;
      fakeBody.appendChild(div);
      if ( !body ) {
                fakeBody.style.background = '';
                fakeBody.style.overflow = 'hidden';
          docOverflow = docElement.style.overflow;
          docElement.style.overflow = 'hidden';
          docElement.appendChild(fakeBody);
      }

      ret = callback(div, rule);
        if ( !body ) {
          fakeBody.parentNode.removeChild(fakeBody);
          docElement.style.overflow = docOverflow;
      } else {
          div.parentNode.removeChild(div);
      }

      return !!ret;

    },



    isEventSupported = (function() {

      var TAGNAMES = {
        'select': 'input', 'change': 'input',
        'submit': 'form', 'reset': 'form',
        'error': 'img', 'load': 'img', 'abort': 'img'
      };

      function isEventSupported( eventName, element ) {

        element = element || document.createElement(TAGNAMES[eventName] || 'div');
        eventName = 'on' + eventName;

            var isSupported = eventName in element;

        if ( !isSupported ) {
                if ( !element.setAttribute ) {
            element = document.createElement('div');
          }
          if ( element.setAttribute && element.removeAttribute ) {
            element.setAttribute(eventName, '');
            isSupported = is(element[eventName], 'function');

                    if ( !is(element[eventName], 'undefined') ) {
              element[eventName] = undefined;
            }
            element.removeAttribute(eventName);
          }
        }

        element = null;
        return isSupported;
      }
      return isEventSupported;
    })(),


    _hasOwnProperty = ({}).hasOwnProperty, hasOwnProp;

    if ( !is(_hasOwnProperty, 'undefined') && !is(_hasOwnProperty.call, 'undefined') ) {
      hasOwnProp = function (object, property) {
        return _hasOwnProperty.call(object, property);
      };
    }
    else {
      hasOwnProp = function (object, property) { 
        return ((property in object) && is(object.constructor.prototype[property], 'undefined'));
      };
    }


    if (!Function.prototype.bind) {
      Function.prototype.bind = function bind(that) {

        var target = this;

        if (typeof target != "function") {
            throw new TypeError();
        }

        var args = slice.call(arguments, 1),
            bound = function () {

            if (this instanceof bound) {

              var F = function(){};
              F.prototype = target.prototype;
              var self = new F();

              var result = target.apply(
                  self,
                  args.concat(slice.call(arguments))
              );
              if (Object(result) === result) {
                  return result;
              }
              return self;

            } else {

              return target.apply(
                  that,
                  args.concat(slice.call(arguments))
              );

            }

        };

        return bound;
      };
    }

    function setCss( str ) {
        mStyle.cssText = str;
    }

    function setCssAll( str1, str2 ) {
        return setCss(prefixes.join(str1 + ';') + ( str2 || '' ));
    }

    function is( obj, type ) {
        return typeof obj === type;
    }

    function contains( str, substr ) {
        return !!~('' + str).indexOf(substr);
    }

    function testProps( props, prefixed ) {
        for ( var i in props ) {
            var prop = props[i];
            if ( !contains(prop, "-") && mStyle[prop] !== undefined ) {
                return prefixed == 'pfx' ? prop : true;
            }
        }
        return false;
    }

    function testDOMProps( props, obj, elem ) {
        for ( var i in props ) {
            var item = obj[props[i]];
            if ( item !== undefined) {

                            if (elem === false) return props[i];

                            if (is(item, 'function')){
                                return item.bind(elem || obj);
                }

                            return item;
            }
        }
        return false;
    }

    function testPropsAll( prop, prefixed, elem ) {

        var ucProp  = prop.charAt(0).toUpperCase() + prop.slice(1),
            props   = (prop + ' ' + cssomPrefixes.join(ucProp + ' ') + ucProp).split(' ');

            if(is(prefixed, "string") || is(prefixed, "undefined")) {
          return testProps(props, prefixed);

            } else {
          props = (prop + ' ' + (domPrefixes).join(ucProp + ' ') + ucProp).split(' ');
          return testDOMProps(props, prefixed, elem);
        }
    }



    tests['canvas'] = function() {
        var elem = document.createElement('canvas');
        return !!(elem.getContext && elem.getContext('2d'));
    };

    tests['canvastext'] = function() {
        return !!(Modernizr['canvas'] && is(document.createElement('canvas').getContext('2d').fillText, 'function'));
    };
    tests['touch'] = function() {
        var bool;

        if(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
          bool = true;
        } else {
          injectElementWithStyles(['@media (',prefixes.join('touch-enabled),('),mod,')','{#modernizr{top:9px;position:absolute}}'].join(''), function( node ) {
            bool = node.offsetTop === 9;
          });
        }

        return bool;
    };

    tests['draganddrop'] = function() {
        var div = document.createElement('div');
        return ('draggable' in div) || ('ondragstart' in div && 'ondrop' in div);
    };


    tests['csstransforms'] = function() {
        return !!testPropsAll('transform');
    };


    tests['svg'] = function() {
        return !!document.createElementNS && !!document.createElementNS(ns.svg, 'svg').createSVGRect;
    };

    tests['inlinesvg'] = function() {
      var div = document.createElement('div');
      div.innerHTML = '<svg/>';
      return (div.firstChild && div.firstChild.namespaceURI) == ns.svg;
    };



    tests['svgclippaths'] = function() {
        return !!document.createElementNS && /SVGClipPath/.test(toString.call(document.createElementNS(ns.svg, 'clipPath')));
    };

    for ( var feature in tests ) {
        if ( hasOwnProp(tests, feature) ) {
                                    featureName  = feature.toLowerCase();
            Modernizr[featureName] = tests[feature]();

            classes.push((Modernizr[featureName] ? '' : 'no-') + featureName);
        }
    }



     Modernizr.addTest = function ( feature, test ) {
       if ( typeof feature == 'object' ) {
         for ( var key in feature ) {
           if ( hasOwnProp( feature, key ) ) {
             Modernizr.addTest( key, feature[ key ] );
           }
         }
       } else {

         feature = feature.toLowerCase();

         if ( Modernizr[feature] !== undefined ) {
                                              return Modernizr;
         }

         test = typeof test == 'function' ? test() : test;

         if (typeof enableClasses !== "undefined" && enableClasses) {
           docElement.className += ' ' + (test ? '' : 'no-') + feature;
         }
         Modernizr[feature] = test;

       }

       return Modernizr; 
     };


    setCss('');
    modElem = inputElem = null;


    Modernizr._version      = version;

    Modernizr._prefixes     = prefixes;
    Modernizr._domPrefixes  = domPrefixes;
    Modernizr._cssomPrefixes  = cssomPrefixes;


    Modernizr.hasEvent      = isEventSupported;

    Modernizr.testProp      = function(prop){
        return testProps([prop]);
    };

    Modernizr.testAllProps  = testPropsAll;


    Modernizr.testStyles    = injectElementWithStyles;
    return Modernizr;

})(window, window.document);
// data uri test.
// https://github.com/Modernizr/Modernizr/issues/14

// This test is asynchronous. Watch out.


// in IE7 in HTTPS this can cause a Mixed Content security popup. 
//  github.com/Modernizr/Modernizr/issues/362
// To avoid that you can create a new iframe and inject this.. perhaps..


(function(){

  var datauri = new Image();


  datauri.onerror = function() {
      Modernizr.addTest('datauri', function () { return false; });
  };  
  datauri.onload = function() {
      Modernizr.addTest('datauri', function () { return (datauri.width == 1 && datauri.height == 1); });
  };

  datauri.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";

})();
;

  // Attach to jQuery object
  $.Jcrop = Jcrop;

  $.Jcrop.supportsCanvas = Modernizr.canvas;
  $.Jcrop.supportsCanvasText = Modernizr.canvastext;
  $.Jcrop.supportsDragAndDrop = Modernizr.draganddrop;
  $.Jcrop.supportsDataURI = Modernizr.datauri;
  $.Jcrop.supportsSVG = Modernizr.svg;
  $.Jcrop.supportsInlineSVG = Modernizr.inlinesvg;
  $.Jcrop.supportsSVGClipPaths = Modernizr.svgclippaths;
  $.Jcrop.supportsCSSTransforms = Modernizr.csstransforms;
  $.Jcrop.supportsTouch = Modernizr.touch;

})(jQuery);

/*!
 * jQuery Color Animations v2.0pre
 * http://jquery.org/
 *
 * Copyright 2011 John Resig
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 */

(function( jQuery, undefined ){
	var stepHooks = "backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color outlineColor".split(" "),

		// plusequals test for += 100 -= 100
		rplusequals = /^([\-+])=\s*(\d+\.?\d*)/,
		// a set of RE's that can match strings and generate color tuples.
		stringParsers = [{
				re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
				parse: function( execResult ) {
					return [
						execResult[ 1 ],
						execResult[ 2 ],
						execResult[ 3 ],
						execResult[ 4 ]
					];
				}
			}, {
				re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
				parse: function( execResult ) {
					return [
						2.55 * execResult[1],
						2.55 * execResult[2],
						2.55 * execResult[3],
						execResult[ 4 ]
					];
				}
			}, {
				re: /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,
				parse: function( execResult ) {
					return [
						parseInt( execResult[ 1 ], 16 ),
						parseInt( execResult[ 2 ], 16 ),
						parseInt( execResult[ 3 ], 16 )
					];
				}
			}, {
				re: /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/,
				parse: function( execResult ) {
					return [
						parseInt( execResult[ 1 ] + execResult[ 1 ], 16 ),
						parseInt( execResult[ 2 ] + execResult[ 2 ], 16 ),
						parseInt( execResult[ 3 ] + execResult[ 3 ], 16 )
					];
				}
			}, {
				re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
				space: "hsla",
				parse: function( execResult ) {
					return [
						execResult[1],
						execResult[2] / 100,
						execResult[3] / 100,
						execResult[4]
					];
				}
			}],

		// jQuery.Color( )
		color = jQuery.Color = function( color, green, blue, alpha ) {
			return new jQuery.Color.fn.parse( color, green, blue, alpha );
		},
		spaces = {
			rgba: {
				cache: "_rgba",
				props: {
					red: {
						idx: 0,
						type: "byte",
						empty: true
					},
					green: {
						idx: 1,
						type: "byte",
						empty: true
					},
					blue: {
						idx: 2,
						type: "byte",
						empty: true
					},
					alpha: {
						idx: 3,
						type: "percent",
						def: 1
					}
				}
			},
			hsla: {
				cache: "_hsla",
				props: {
					hue: {
						idx: 0,
						type: "degrees",
						empty: true
					},
					saturation: {
						idx: 1,
						type: "percent",
						empty: true
					},
					lightness: {
						idx: 2,
						type: "percent",
						empty: true
					}
				}
			}
		},
		propTypes = {
			"byte": {
				floor: true,
				min: 0,
				max: 255
			},
			"percent": {
				min: 0,
				max: 1
			},
			"degrees": {
				mod: 360,
				floor: true
			}
		},
		rgbaspace = spaces.rgba.props,
		support = color.support = {},

		// colors = jQuery.Color.names
		colors,

		// local aliases of functions called often
		each = jQuery.each;

	spaces.hsla.props.alpha = rgbaspace.alpha;

	function clamp( value, prop, alwaysAllowEmpty ) {
		var type = propTypes[ prop.type ] || {},
			allowEmpty = prop.empty || alwaysAllowEmpty;

		if ( allowEmpty && value == null ) {
			return null;
		}
		if ( prop.def && value == null ) {
			return prop.def;
		}
		if ( type.floor ) {
			value = ~~value;
		} else {
			value = parseFloat( value );
		}
		if ( value == null || isNaN( value ) ) {
			return prop.def;
		}
		if ( type.mod ) {
			value = value % type.mod;
			// -10 -> 350
			return value < 0 ? type.mod + value : value;
		}

		// for now all property types without mod have min and max
		return type.min > value ? type.min : type.max < value ? type.max : value;
	}

	function stringParse( string ) {
		var inst = color(),
			rgba = inst._rgba = [];

		string = string.toLowerCase();

		each( stringParsers, function( i, parser ) {
			var match = parser.re.exec( string ),
				values = match && parser.parse( match ),
				parsed,
				spaceName = parser.space || "rgba",
				cache = spaces[ spaceName ].cache;


			if ( values ) {
				parsed = inst[ spaceName ]( values );

				// if this was an rgba parse the assignment might happen twice
				// oh well....
				inst[ cache ] = parsed[ cache ];
				rgba = inst._rgba = parsed._rgba;

				// exit each( stringParsers ) here because we matched
				return false;
			}
		});

		// Found a stringParser that handled it
		if ( rgba.length !== 0 ) {

			// if this came from a parsed string, force "transparent" when alpha is 0
			// chrome, (and maybe others) return "transparent" as rgba(0,0,0,0)
			if ( Math.max.apply( Math, rgba ) === 0 ) {
				jQuery.extend( rgba, colors.transparent );
			}
			return inst;
		}

		// named colors / default - filter back through parse function
		if ( string = colors[ string ] ) {
			return string;
		}
	}

	color.fn = color.prototype = {
		constructor: color,
		parse: function( red, green, blue, alpha ) {
			if ( red === undefined ) {
				this._rgba = [ null, null, null, null ];
				return this;
			}
			if ( red instanceof jQuery || red.nodeType ) {
				red = red instanceof jQuery ? red.css( green ) : jQuery( red ).css( green );
				green = undefined;
			}

			var inst = this,
				type = jQuery.type( red ),
				rgba = this._rgba = [],
				source;

			// more than 1 argument specified - assume ( red, green, blue, alpha )
			if ( green !== undefined ) {
				red = [ red, green, blue, alpha ];
				type = "array";
			}

			if ( type === "string" ) {
				return this.parse( stringParse( red ) || colors._default );
			}

			if ( type === "array" ) {
				each( rgbaspace, function( key, prop ) {
					rgba[ prop.idx ] = clamp( red[ prop.idx ], prop );
				});
				return this;
			}

			if ( type === "object" ) {
				if ( red instanceof color ) {
					each( spaces, function( spaceName, space ) {
						if ( red[ space.cache ] ) {
							inst[ space.cache ] = red[ space.cache ].slice();
						}
					});
				} else {
					each( spaces, function( spaceName, space ) {
						each( space.props, function( key, prop ) {
							var cache = space.cache;

							// if the cache doesn't exist, and we know how to convert
							if ( !inst[ cache ] && space.to ) {

								// if the value was null, we don't need to copy it
								// if the key was alpha, we don't need to copy it either
								if ( red[ key ] == null || key === "alpha") {
									return;
								}
								inst[ cache ] = space.to( inst._rgba );
							}

							// this is the only case where we allow nulls for ALL properties.
							// call clamp with alwaysAllowEmpty
							inst[ cache ][ prop.idx ] = clamp( red[ key ], prop, true );
						});
					});
				}
				return this;
			}
		},
		is: function( compare ) {
			var is = color( compare ),
				same = true,
				myself = this;

			each( spaces, function( _, space ) {
				var isCache = is[ space.cache ],
					localCache;
				if (isCache) {
					localCache = myself[ space.cache ] || space.to && space.to( myself._rgba ) || [];
					each( space.props, function( _, prop ) {
						if ( isCache[ prop.idx ] != null ) {
							same = ( isCache[ prop.idx ] === localCache[ prop.idx ] );
							return same;
						}
					});
				}
				return same;
			});
			return same;
		},
		_space: function() {
			var used = [],
				inst = this;
			each( spaces, function( spaceName, space ) {
				if ( inst[ space.cache ] ) {
					used.push( spaceName );
				}
			});
			return used.pop();
		},
		transition: function( other, distance ) {
			var end = color( other ),
				spaceName = end._space(),
				space = spaces[ spaceName ],
				start = this[ space.cache ] || space.to( this._rgba ),
				result = start.slice();

			end = end[ space.cache ];
			each( space.props, function( key, prop ) {
				var index = prop.idx,
					startValue = start[ index ],
					endValue = end[ index ],
					type = propTypes[ prop.type ] || {};

				// if null, don't override start value
				if ( endValue === null ) {
					return;
				}
				// if null - use end
				if ( startValue === null ) {
					result[ index ] = endValue;
				} else {
					if ( type.mod ) {
						if ( endValue - startValue > type.mod / 2 ) {
							startValue += type.mod;
						} else if ( startValue - endValue > type.mod / 2 ) {
							startValue -= type.mod;
						}
					}
					result[ prop.idx ] = clamp( ( endValue - startValue ) * distance + startValue, prop );
				}
			});
			return this[ spaceName ]( result );
		},
		blend: function( opaque ) {
			// if we are already opaque - return ourself
			if ( this._rgba[ 3 ] === 1 ) {
				return this;
			}

			var rgb = this._rgba.slice(),
				a = rgb.pop(),
				blend = color( opaque )._rgba;

			return color( jQuery.map( rgb, function( v, i ) {
				return ( 1 - a ) * blend[ i ] + a * v;
			}));
		},
		toRgbaString: function() {
			var prefix = "rgba(",
				rgba = jQuery.map( this._rgba, function( v, i ) {
					return v == null ? ( i > 2 ? 1 : 0 ) : v;
				});

			if ( rgba[ 3 ] === 1 ) {
				rgba.pop();
				prefix = "rgb(";
			}

			return prefix + rgba.join(",") + ")";
		},
		toHslaString: function() {
			var prefix = "hsla(",
				hsla = jQuery.map( this.hsla(), function( v, i ) {
					if ( v == null ) {
						v = i > 2 ? 1 : 0;
					}

					// catch 1 and 2
					if ( i && i < 3 ) {
						v = Math.round( v * 100 ) + "%";
					}
					return v;
				});

			if ( hsla[ 3 ] === 1 ) {
				hsla.pop();
				prefix = "hsl(";
			}
			return prefix + hsla.join(",") + ")";
		},
		toHexString: function( includeAlpha ) {
			var rgba = this._rgba.slice(),
				alpha = rgba.pop();

			if ( includeAlpha ) {
				rgba.push( ~~( alpha * 255 ) );
			}

			return "#" + jQuery.map( rgba, function( v, i ) {

				// default to 0 when nulls exist
				v = ( v || 0 ).toString( 16 );
				return v.length === 1 ? "0" + v : v;
			}).join("");
		},
		toString: function() {
			return this._rgba[ 3 ] === 0 ? "transparent" : this.toRgbaString();
		}
	};
	color.fn.parse.prototype = color.fn;

	// hsla conversions adapted from:
	// http://www.google.com/codesearch/p#OAMlx_jo-ck/src/third_party/WebKit/Source/WebCore/inspector/front-end/Color.js&d=7&l=193

	function hue2rgb( p, q, h ) {
		h = ( h + 1 ) % 1;
		if ( h * 6 < 1 ) {
			return p + (q - p) * 6 * h;
		}
		if ( h * 2 < 1) {
			return q;
		}
		if ( h * 3 < 2 ) {
			return p + (q - p) * ((2/3) - h) * 6;
		}
		return p;
	}

	spaces.hsla.to = function ( rgba ) {
		if ( rgba[ 0 ] == null || rgba[ 1 ] == null || rgba[ 2 ] == null ) {
			return [ null, null, null, rgba[ 3 ] ];
		}
		var r = rgba[ 0 ] / 255,
			g = rgba[ 1 ] / 255,
			b = rgba[ 2 ] / 255,
			a = rgba[ 3 ],
			max = Math.max( r, g, b ),
			min = Math.min( r, g, b ),
			diff = max - min,
			add = max + min,
			l = add * 0.5,
			h, s;

		if ( min === max ) {
			h = 0;
		} else if ( r === max ) {
			h = ( 60 * ( g - b ) / diff ) + 360;
		} else if ( g === max ) {
			h = ( 60 * ( b - r ) / diff ) + 120;
		} else {
			h = ( 60 * ( r - g ) / diff ) + 240;
		}

		if ( l === 0 || l === 1 ) {
			s = l;
		} else if ( l <= 0.5 ) {
			s = diff / add;
		} else {
			s = diff / ( 2 - add );
		}
		return [ Math.round(h) % 360, s, l, a == null ? 1 : a ];
	};

	spaces.hsla.from = function ( hsla ) {
		if ( hsla[ 0 ] == null || hsla[ 1 ] == null || hsla[ 2 ] == null ) {
			return [ null, null, null, hsla[ 3 ] ];
		}
		var h = hsla[ 0 ] / 360,
			s = hsla[ 1 ],
			l = hsla[ 2 ],
			a = hsla[ 3 ],
			q = l <= 0.5 ? l * ( 1 + s ) : l + s - l * s,
			p = 2 * l - q,
			r, g, b;

		return [
			Math.round( hue2rgb( p, q, h + ( 1 / 3 ) ) * 255 ),
			Math.round( hue2rgb( p, q, h ) * 255 ),
			Math.round( hue2rgb( p, q, h - ( 1 / 3 ) ) * 255 ),
			a
		];
	};


	each( spaces, function( spaceName, space ) {
		var props = space.props,
			cache = space.cache,
			to = space.to,
			from = space.from;

		// makes rgba() and hsla()
		color.fn[ spaceName ] = function( value ) {

			// generate a cache for this space if it doesn't exist
			if ( to && !this[ cache ] ) {
				this[ cache ] = to( this._rgba );
			}
			if ( value === undefined ) {
				return this[ cache ].slice();
			}

			var type = jQuery.type( value ),
				arr = ( type === "array" || type === "object" ) ? value : arguments,
				local = this[ cache ].slice(),
				ret;

			each( props, function( key, prop ) {
				var val = arr[ type === "object" ? key : prop.idx ];
				if ( val == null ) {
					val = local[ prop.idx ];
				}
				local[ prop.idx ] = clamp( val, prop );
			});

			if ( from ) {
				ret = color( from( local ) );
				ret[ cache ] = local;
				return ret;
			} else {
				return color( local );
			}
		};

		// makes red() green() blue() alpha() hue() saturation() lightness()
		each( props, function( key, prop ) {
			// alpha is included in more than one space
			if ( color.fn[ key ] ) {
				return;
			}
			color.fn[ key ] = function( value ) {
				var vtype = jQuery.type( value ),
					fn = ( key === 'alpha' ? ( this._hsla ? 'hsla' : 'rgba' ) : spaceName ),
					local = this[ fn ](),
					cur = local[ prop.idx ],
					match;

				if ( vtype === "undefined" ) {
					return cur;
				}

				if ( vtype === "function" ) {
					value = value.call( this, cur );
					vtype = jQuery.type( value );
				}
				if ( value == null && prop.empty ) {
					return this;
				}
				if ( vtype === "string" ) {
					match = rplusequals.exec( value );
					if ( match ) {
						value = cur + parseFloat( match[ 2 ] ) * ( match[ 1 ] === "+" ? 1 : -1 );
					}
				}
				local[ prop.idx ] = value;
				return this[ fn ]( local );
			};
		});
	});

	// add .fx.step functions
	each( stepHooks, function( i, hook ) {
		jQuery.cssHooks[ hook ] = {
			set: function( elem, value ) {
				var parsed, backgroundColor, curElem;

				if ( jQuery.type( value ) !== 'string' || ( parsed = stringParse( value ) ) )
				{
					value = color( parsed || value );
					if ( !support.rgba && value._rgba[ 3 ] !== 1 ) {
						curElem = hook === "backgroundColor" ? elem.parentNode : elem;
						do {
							backgroundColor = jQuery.curCSS( curElem, "backgroundColor" );
						} while (
							( backgroundColor === "" || backgroundColor === "transparent" ) &&
							( curElem = curElem.parentNode ) &&
							curElem.style
						);

						value = value.blend( backgroundColor && backgroundColor !== "transparent" ?
							backgroundColor :
							"_default" );
					}

					value = value.toRgbaString();
				}
				elem.style[ hook ] = value;
			}
		};
		jQuery.fx.step[ hook ] = function( fx ) {
			if ( !fx.colorInit ) {
				fx.start = color( fx.elem, hook );
				fx.end = color( fx.end );
				fx.colorInit = true;
			}
			jQuery.cssHooks[ hook ].set( fx.elem, fx.start.transition( fx.end, fx.pos ) );
		};
	});

	// detect rgba support
	jQuery(function() {
		var div = document.createElement( "div" ),
			div_style = div.style;

		div_style.cssText = "background-color:rgba(1,1,1,.5)";
		support.rgba = div_style.backgroundColor.indexOf( "rgba" ) > -1;
	});

	// Some named colors to work with
	// From Interface by Stefan Petre
	// http://interface.eyecon.ro/
	colors = jQuery.Color.names = {
		aqua: "#00ffff",
		azure: "#f0ffff",
		beige: "#f5f5dc",
		black: "#000000",
		blue: "#0000ff",
		brown: "#a52a2a",
		cyan: "#00ffff",
		darkblue: "#00008b",
		darkcyan: "#008b8b",
		darkgray: "#a9a9a9",
		darkgreen: "#006400",
		darkkhaki: "#bdb76b",
		darkmagenta: "#8b008b",
		darkolivegreen: "#556b2f",
		darkorange: "#ff8c00",
		darkorchid: "#9932cc",
		darkred: "#8b0000",
		darksalmon: "#e9967a",
		darkviolet: "#9400d3",
		fuchsia: "#ff00ff",
		gold: "#ffd700",
		green: "#008000",
		indigo: "#4b0082",
		khaki: "#f0e68c",
		lightblue: "#add8e6",
		lightcyan: "#e0ffff",
		lightgreen: "#90ee90",
		lightgray: "#d3d3d3",
		lightpink: "#ffb6c1",
		lightyellow: "#ffffe0",
		lime: "#00ff00",
		magenta: "#ff00ff",
		maroon: "#800000",
		navy: "#000080",
		olive: "#808000",
		orange: "#ffa500",
		pink: "#ffc0cb",
		purple: "#800080",
		violet: "#800080",
		red: "#ff0000",
		silver: "#c0c0c0",
		white: "#ffffff",
		yellow: "#ffff00",
		transparent: [ null, null, null, 0 ],
		_default: "#ffffff"
	};
})( jQuery );


/*
	commonJs
*/

function SAtoggleClass(element, parentClass, toggleClass, hasClass, className) {

	$(element).parents(parentClass).toggleClass(toggleClass);

	if(hasClass) {

		$(element).toggleClass(className);		

	}

	return false;

}


function SASetClass(element) {

	if($(element).is(':checked')) {

		localStorage.setItem($(element).attr('id'), true);

		$('body').removeClass($(element).data('remove-class')).addClass($(element).data('add-class'));		

	} 
	else {

		localStorage.setItem($(element).attr('id'), false);

		$('body').removeClass($(element).data('remove-class'));

	}


	if(!$(element).is(':checked')) {
		
		if($(element).attr('id') == 'SAFixedHeader'){

			localStorage.setItem('SAFixedHeader', false);
			localStorage.setItem('SAFixedNavigation', false);
			localStorage.setItem('SAFixedRibbon', false);

			$('#SAFixedNavigation, #SAFixedRibbon').prop('checked', false);
		}

		if($(element).attr('id') == 'SAFixedNavigation'){

			$('#SAFixedRibbon').prop('checked', false);
			localStorage.setItem('SAFixedRibbon', false);
		}

		if($(element).attr('id') == 'SAMenuOnTop'){
			localStorage.setItem('SAMenuOnTop', false);
			location.reload();
		}

	}
	else {
		if($(element).attr('id') == 'SAFixedNavigation'){

			$('#SAFixedHeader').prop('checked', true);
			$('#SAFixedNavigation').prop('checked', true);
			localStorage.setItem('SAFixedHeader', true);
			localStorage.setItem('SAFixedNavigation', true);
		}

		if($(element).attr('id') == 'SAFixedRibbon'){

			$('#SAFixedHeader, #SAFixedNavigation').prop('checked', true);
			localStorage.setItem('SAFixedNavigation', true);
			localStorage.setItem('SAFixedHeader', true);
		}

		if($(element).attr('id') == 'SAMenuOnTop'){

			localStorage.setItem('SAMenuOnTop', true);
			location.reload();
		}
	}
}



function SAMenuSetupOnTop() {

	// SAMenuOnTop
	if(localStorage) {

		if(localStorage.getItem('SAMenuOnTop') && JSON.parse(localStorage.getItem('SAMenuOnTop'))) {
			$('body').removeClass($('#SAMenuOnTop').data('remove-class')).addClass($('#SAMenuOnTop').data('add-class'));		
			$('#SAMenuOnTop').prop('checked', true);
		}
		else {
			$('body').removeClass($('#SAMenuOnTop').data('remove-class'));
			$('#SAMenuOnTop').prop('checked', false);
		}

		
		// SAFixedHeader

		if(localStorage.getItem('SAFixedHeader') && JSON.parse(localStorage.getItem('SAFixedHeader'))) {
			$('body').removeClass($('#SAFixedHeader').data('remove-class')).addClass($('#SAFixedHeader').data('add-class'));		
			$('#SAFixedHeader').prop('checked', true);
		}
		else {
			$('body').removeClass($('#SAFixedHeader').data('remove-class'));
			$('#SAFixedHeader').prop('checked', false);
		}


		// SAFixedNavigation

		if(localStorage.getItem('SAFixedNavigation') && JSON.parse(localStorage.getItem('SAFixedNavigation'))) {
			$('body').removeClass($('#SAFixedNavigation').data('remove-class')).addClass($('#SAFixedNavigation').data('add-class'));		
			$('#SAFixedNavigation').prop('checked', true);
		}
		else {
			$('body').removeClass($('#SAFixedNavigation').data('remove-class'));
			$('#SAFixedNavigation').prop('checked', false);
		}


		// SAFixedRibbon

		if(localStorage.getItem('SAFixedRibbon') && JSON.parse(localStorage.getItem('SAFixedRibbon'))) {
			$('body').removeClass($('#SAFixedRibbon').data('remove-class')).addClass($('#SAFixedRibbon').data('add-class'));		
			$('#SAFixedRibbon').prop('checked', true);
		}
		else {
			$('body').removeClass($('#SAFixedRibbon').data('remove-class'));
			$('#SAFixedRibbon').prop('checked', false);
		}
	}	

}


function loadNotifications(element) {
	console.log($(element).data('url'));
	var url = $(element).data('url');
	var container = $('.sa-ajax-notification-container');

	$(element).addClass('active').siblings().removeClass('active');
	loadAjaxContent(url, container);

}


function loadAjaxContent(url, container) {
	$.ajax({
		type: "GET",
        url: url,
        dataType: "html",
        cache: !0,
        success: function(e) {
            container.css({
                opacity: "0.0"
            }).html(e).delay(50).animate({
                opacity: "1.0"
            }, 300),
            e = null,
            container = null
        },
        error: function(a, o, n, i) {
            container.html('<h4 class="ajax-loading-error"><i class="fa fa-warning text-orange-dark"></i> Error requesting <span class="text-red">' + url + "</span>: " + a.status + ' <span style="text-transform: capitalize;">' + n + "</span></h4>")
        },
        async: !0
	})

}




function toggleReloadButton(element, event) {

	event.stopPropagation();

	$(element).addClass('disabled').html(smartadmin.toggleReloadButton.loadingHTML);

	setTimeout(function() {

		$(element).removeClass('disabled').html(smartadmin.toggleReloadButton.resetHTML);

	}, 3e3);

}


function toggleFullScreen() {
	smartadmin.launchFullscreen();
}

$('.sa-activity-dropdown-toggle').click(function(){
	$(this).find('.badge').removeClass('bg-red');
})


$(document).keyup(function(e){
   if(e.which==122) {

      smartadmin.launchFullscreen();

   }else if(e.which==27) {

   		$('body').removeClass(smartadmin.classesName.fullScreen);   	


   }

});


$(document).ready(function(){
	$('body').click(function(){

		if($('.'+smartadmin.classesName.shortcutsSection).height()) {

			$(this).removeClass('sa-shortcuts-expanded');
			
		}
	})
})

SAMenuSetupOnTop();


function applySparkline() {
	if ($.fn.sparkline) {
	
		// variable declearations:
	
		var barColor,
		    sparklineHeight,
		    sparklineBarWidth,
		    sparklineBarSpacing,
		    sparklineNegBarColor,
		    sparklineStackedColor,
		    thisLineColor,
		    thisLineWidth,
		    thisFill,
		    thisSpotColor,
		    thisMinSpotColor,
		    thisMaxSpotColor,
		    thishighlightSpotColor,
		    thisHighlightLineColor,
		    thisSpotRadius,			        
			pieColors,
		    pieWidthHeight,
		    pieBorderColor,
		    pieOffset,
		 	thisBoxWidth,
		    thisBoxHeight,
		    thisBoxRaw,
		    thisBoxTarget,
		    thisBoxMin,
		    thisBoxMax,
		    thisShowOutlier,
		    thisIQR,
		    thisBoxSpotRadius,
		    thisBoxLineColor,
		    thisBoxFillColor,
		    thisBoxWhisColor,
		    thisBoxOutlineColor,
		    thisBoxOutlineFill,
		    thisBoxMedianColor,
		    thisBoxTargetColor,
			thisBulletHeight,
		    thisBulletWidth,
		    thisBulletColor,
		    thisBulletPerformanceColor,
		    thisBulletRangeColors,
			thisDiscreteHeight,
		    thisDiscreteWidth,
		    thisDiscreteLineColor,
		    thisDiscreteLineHeight,
		    thisDiscreteThrushold,
		    thisDiscreteThrusholdColor,
			thisTristateHeight,
		    thisTristatePosBarColor,
		    thisTristateNegBarColor,
		    thisTristateZeroBarColor,
		    thisTristateBarWidth,
		    thisTristateBarSpacing,
		    thisZeroAxis,
		    thisBarColor,
		    sparklineWidth,
		    sparklineValue,
		    sparklineValueSpots1,
		    sparklineValueSpots2,
		    thisLineWidth1,
		    thisLineWidth2,
		    thisLineColor1,
		    thisLineColor2,
		    thisSpotRadius1,
		    thisSpotRadius2,
		    thisMinSpotColor1,
		    thisMaxSpotColor1,
		    thisMinSpotColor2,
		    thisMaxSpotColor2,
		    thishighlightSpotColor1,
		    thisHighlightLineColor1,
		    thishighlightSpotColor2,
		    thisFillColor1,
		    thisFillColor2;
				    				    	
		$('.sparkline:not(:has(>canvas))').each(function() {
			var $this = $(this),
				sparklineType = $this.data('sparkline-type') || 'bar';
	
			// BAR CHART
			if (sparklineType == 'bar') {
	
					barColor = $this.data('sparkline-bar-color') || $this.css('color') || '#0000f0';
				    sparklineHeight = $this.data('sparkline-height') || '26px';
				    sparklineBarWidth = $this.data('sparkline-barwidth') || 5;
				    sparklineBarSpacing = $this.data('sparkline-barspacing') || 2;
				    sparklineNegBarColor = $this.data('sparkline-negbar-color') || '#A90329';
				    sparklineStackedColor = $this.data('sparkline-barstacked-color') || ["#A90329", "#0099c6", "#98AA56", "#da532c", "#4490B1", "#6E9461", "#990099", "#B4CAD3"];
				        
				$this.sparkline('html', {
					barColor : barColor,
					type : sparklineType,
					height : sparklineHeight,
					barWidth : sparklineBarWidth,
					barSpacing : sparklineBarSpacing,
					stackedBarColor : sparklineStackedColor,
					negBarColor : sparklineNegBarColor,
					zeroAxis : 'false'
				});
				
				$this = null;
	
			}
	
			// LINE CHART
			if (sparklineType == 'line') {
	
					sparklineHeight = $this.data('sparkline-height') || '20px';
				    sparklineWidth = $this.data('sparkline-width') || '90px';
				    thisLineColor = $this.data('sparkline-line-color') || $this.css('color') || '#0000f0';
				    thisLineWidth = $this.data('sparkline-line-width') || 1;
				    thisFill = $this.data('fill-color') || '#c0d0f0';
				    thisSpotColor = $this.data('sparkline-spot-color') || '#f08000';
				    thisMinSpotColor = $this.data('sparkline-minspot-color') || '#ed1c24';
				    thisMaxSpotColor = $this.data('sparkline-maxspot-color') || '#f08000';
				    thishighlightSpotColor = $this.data('sparkline-highlightspot-color') || '#50f050';
				    thisHighlightLineColor = $this.data('sparkline-highlightline-color') || 'f02020';
				    thisSpotRadius = $this.data('sparkline-spotradius') || 1.5;
					thisChartMinYRange = $this.data('sparkline-min-y') || 'undefined'; 
					thisChartMaxYRange = $this.data('sparkline-max-y') || 'undefined'; 
					thisChartMinXRange = $this.data('sparkline-min-x') || 'undefined'; 
					thisChartMaxXRange = $this.data('sparkline-max-x') || 'undefined'; 
					thisMinNormValue = $this.data('min-val') || 'undefined'; 
					thisMaxNormValue = $this.data('max-val') || 'undefined'; 
					thisNormColor =  $this.data('norm-color') || '#c0c0c0';
					thisDrawNormalOnTop = $this.data('draw-normal') || false;
				    
				$this.sparkline('html', {
					type : 'line',
					width : sparklineWidth,
					height : sparklineHeight,
					lineWidth : thisLineWidth,
					lineColor : thisLineColor,
					fillColor : thisFill,
					spotColor : thisSpotColor,
					minSpotColor : thisMinSpotColor,
					maxSpotColor : thisMaxSpotColor,
					highlightSpotColor : thishighlightSpotColor,
					highlightLineColor : thisHighlightLineColor,
					spotRadius : thisSpotRadius,
					chartRangeMin : thisChartMinYRange,
					chartRangeMax : thisChartMaxYRange,
					chartRangeMinX : thisChartMinXRange,
					chartRangeMaxX : thisChartMaxXRange,
					normalRangeMin : thisMinNormValue,
					normalRangeMax : thisMaxNormValue,
					normalRangeColor : thisNormColor,
					drawNormalOnTop : thisDrawNormalOnTop
	
				});
				
				$this = null;
	
			}
	
			// PIE CHART
			if (sparklineType == 'pie') {
	
					pieColors = $this.data('sparkline-piecolor') || ["#B4CAD3", "#4490B1", "#98AA56", "#da532c","#6E9461", "#0099c6", "#990099", "#717D8A"];
				    pieWidthHeight = $this.data('sparkline-piesize') || 90;
				    pieBorderColor = $this.data('border-color') || '#45494C';
				    pieOffset = $this.data('sparkline-offset') || 0;
				    
				$this.sparkline('html', {
					type : 'pie',
					width : pieWidthHeight,
					height : pieWidthHeight,
					tooltipFormat : '<span style="color: {{color}}">&#9679;</span> ({{percent.1}}%)',
					sliceColors : pieColors,
					borderWidth : 1,
					offset : pieOffset,
					borderColor : pieBorderColor
				});
				
				$this = null;
	
			}
	
			// BOX PLOT
			if (sparklineType == 'box') {
	
					thisBoxWidth = $this.data('sparkline-width') || 'auto';
				    thisBoxHeight = $this.data('sparkline-height') || 'auto';
				    thisBoxRaw = $this.data('sparkline-boxraw') || false;
				    thisBoxTarget = $this.data('sparkline-targetval') || 'undefined';
				    thisBoxMin = $this.data('sparkline-min') || 'undefined';
				    thisBoxMax = $this.data('sparkline-max') || 'undefined';
				    thisShowOutlier = $this.data('sparkline-showoutlier') || true;
				    thisIQR = $this.data('sparkline-outlier-iqr') || 1.5;
				    thisBoxSpotRadius = $this.data('sparkline-spotradius') || 1.5;
				    thisBoxLineColor = $this.css('color') || '#000000';
				    thisBoxFillColor = $this.data('fill-color') || '#c0d0f0';
				    thisBoxWhisColor = $this.data('sparkline-whis-color') || '#000000';
				    thisBoxOutlineColor = $this.data('sparkline-outline-color') || '#303030';
				    thisBoxOutlineFill = $this.data('sparkline-outlinefill-color') || '#f0f0f0';
				    thisBoxMedianColor = $this.data('sparkline-outlinemedian-color') || '#f00000';
				    thisBoxTargetColor = $this.data('sparkline-outlinetarget-color') || '#40a020';
				    
				$this.sparkline('html', {
					type : 'box',
					width : thisBoxWidth,
					height : thisBoxHeight,
					raw : thisBoxRaw,
					target : thisBoxTarget,
					minValue : thisBoxMin,
					maxValue : thisBoxMax,
					showOutliers : thisShowOutlier,
					outlierIQR : thisIQR,
					spotRadius : thisBoxSpotRadius,
					boxLineColor : thisBoxLineColor,
					boxFillColor : thisBoxFillColor,
					whiskerColor : thisBoxWhisColor,
					outlierLineColor : thisBoxOutlineColor,
					outlierFillColor : thisBoxOutlineFill,
					medianColor : thisBoxMedianColor,
					targetColor : thisBoxTargetColor
	
				});
				
				$this = null;
	
			}
	
			// BULLET
			if (sparklineType == 'bullet') {
	
				var thisBulletHeight = $this.data('sparkline-height') || 'auto';
				    thisBulletWidth = $this.data('sparkline-width') || 2;
				    thisBulletColor = $this.data('sparkline-bullet-color') || '#ed1c24';
				    thisBulletPerformanceColor = $this.data('sparkline-performance-color') || '#3030f0';
				    thisBulletRangeColors = $this.data('sparkline-bulletrange-color') || ["#d3dafe", "#a8b6ff", "#7f94ff"];
				    
				$this.sparkline('html', {
	
					type : 'bullet',
					height : thisBulletHeight,
					targetWidth : thisBulletWidth,
					targetColor : thisBulletColor,
					performanceColor : thisBulletPerformanceColor,
					rangeColors : thisBulletRangeColors
	
				});
				
				$this = null;
	
			}
	
			// DISCRETE
			if (sparklineType == 'discrete') {
	
				 	thisDiscreteHeight = $this.data('sparkline-height') || 26;
				    thisDiscreteWidth = $this.data('sparkline-width') || 50;
				    thisDiscreteLineColor = $this.css('color');
				    thisDiscreteLineHeight = $this.data('sparkline-line-height') || 5;
				    thisDiscreteThrushold = $this.data('sparkline-threshold') || 'undefined';
				    thisDiscreteThrusholdColor = $this.data('sparkline-threshold-color') || '#ed1c24';
				    
				$this.sparkline('html', {
	
					type : 'discrete',
					width : thisDiscreteWidth,
					height : thisDiscreteHeight,
					lineColor : thisDiscreteLineColor,
					lineHeight : thisDiscreteLineHeight,
					thresholdValue : thisDiscreteThrushold,
					thresholdColor : thisDiscreteThrusholdColor
	
				});
				
				$this = null;
	
			}
	
			// TRISTATE
			if (sparklineType == 'tristate') {
	
				 	thisTristateHeight = $this.data('sparkline-height') || 26;
				    thisTristatePosBarColor = $this.data('sparkline-posbar-color') || '#60f060';
				    thisTristateNegBarColor = $this.data('sparkline-negbar-color') || '#f04040';
				    thisTristateZeroBarColor = $this.data('sparkline-zerobar-color') || '#909090';
				    thisTristateBarWidth = $this.data('sparkline-barwidth') || 5;
				    thisTristateBarSpacing = $this.data('sparkline-barspacing') || 2;
				    thisZeroAxis = $this.data('sparkline-zeroaxis') || false;
				    
				$this.sparkline('html', {
	
					type : 'tristate',
					height : thisTristateHeight,
					posBarColor : thisBarColor,
					negBarColor : thisTristateNegBarColor,
					zeroBarColor : thisTristateZeroBarColor,
					barWidth : thisTristateBarWidth,
					barSpacing : thisTristateBarSpacing,
					zeroAxis : thisZeroAxis
	
				});
				
				$this = null;
	
			}
	
			//COMPOSITE: BAR
			if (sparklineType == 'compositebar') {
	
			 	sparklineHeight = $this.data('sparkline-height') || '20px';
			    sparklineWidth = $this.data('sparkline-width') || '100%';
			    sparklineBarWidth = $this.data('sparkline-barwidth') || 3;
			    thisLineWidth = $this.data('sparkline-line-width') || 1;
			    thisLineColor = $this.data('data-sparkline-linecolor') || '#ed1c24';
			    thisBarColor = $this.data('data-sparkline-barcolor') || '#333333';
				    
				$this.sparkline($this.data('sparkline-bar-val'), {
	
					type : 'bar',
					width : sparklineWidth,
					height : sparklineHeight,
					barColor : thisBarColor,
					barWidth : sparklineBarWidth
					//barSpacing: 5
	
				});
	
				$this.sparkline($this.data('sparkline-line-val'), {
	
					width : sparklineWidth,
					height : sparklineHeight,
					lineColor : thisLineColor,
					lineWidth : thisLineWidth,
					composite : true,
					fillColor : false
	
				});
				
				$this = null;
	
			}
	
			//COMPOSITE: LINE
			if (sparklineType == 'compositeline') {
	
					sparklineHeight = $this.data('sparkline-height') || '20px';
				    sparklineWidth = $this.data('sparkline-width') || '90px';
				    sparklineValue = $this.data('sparkline-bar-val');
				    sparklineValueSpots1 = $this.data('sparkline-bar-val-spots-top') || null;
				    sparklineValueSpots2 = $this.data('sparkline-bar-val-spots-bottom') || null;
				    thisLineWidth1 = $this.data('sparkline-line-width-top') || 1;
				    thisLineWidth2 = $this.data('sparkline-line-width-bottom') || 1;
				    thisLineColor1 = $this.data('sparkline-color-top') || '#333333';
				    thisLineColor2 = $this.data('sparkline-color-bottom') || '#ed1c24';
				    thisSpotRadius1 = $this.data('sparkline-spotradius-top') || 1.5;
				    thisSpotRadius2 = $this.data('sparkline-spotradius-bottom') || thisSpotRadius1;
				    thisSpotColor = $this.data('sparkline-spot-color') || '#f08000';
				    thisMinSpotColor1 = $this.data('sparkline-minspot-color-top') || '#ed1c24';
				    thisMaxSpotColor1 = $this.data('sparkline-maxspot-color-top') || '#f08000';
				    thisMinSpotColor2 = $this.data('sparkline-minspot-color-bottom') || thisMinSpotColor1;
				    thisMaxSpotColor2 = $this.data('sparkline-maxspot-color-bottom') || thisMaxSpotColor1;
				    thishighlightSpotColor1 = $this.data('sparkline-highlightspot-color-top') || '#50f050';
				    thisHighlightLineColor1 = $this.data('sparkline-highlightline-color-top') || '#f02020';
				    thishighlightSpotColor2 = $this.data('sparkline-highlightspot-color-bottom') ||
				        thishighlightSpotColor1;
				    thisHighlightLineColor2 = $this.data('sparkline-highlightline-color-bottom') ||
				        thisHighlightLineColor1;
				    thisFillColor1 = $this.data('sparkline-fillcolor-top') || 'transparent';
				    thisFillColor2 = $this.data('sparkline-fillcolor-bottom') || 'transparent';
				    
				$this.sparkline(sparklineValue, {
	
					type : 'line',
					spotRadius : thisSpotRadius1,
	
					spotColor : thisSpotColor,
					minSpotColor : thisMinSpotColor1,
					maxSpotColor : thisMaxSpotColor1,
					highlightSpotColor : thishighlightSpotColor1,
					highlightLineColor : thisHighlightLineColor1,
	
					valueSpots : sparklineValueSpots1,
	
					lineWidth : thisLineWidth1,
					width : sparklineWidth,
					height : sparklineHeight,
					lineColor : thisLineColor1,
					fillColor : thisFillColor1
	
				});
	
				$this.sparkline($this.data('sparkline-line-val'), {
	
					type : 'line',
					spotRadius : thisSpotRadius2,
	
					spotColor : thisSpotColor,
					minSpotColor : thisMinSpotColor2,
					maxSpotColor : thisMaxSpotColor2,
					highlightSpotColor : thishighlightSpotColor2,
					highlightLineColor : thisHighlightLineColor2,
	
					valueSpots : sparklineValueSpots2,
	
					lineWidth : thisLineWidth2,
					width : sparklineWidth,
					height : sparklineHeight,
					lineColor : thisLineColor2,
					composite : true,
					fillColor : thisFillColor2
	
				});
				
				$this = null;
	
			}
	
		});
	
	}// end if
}


function applyEasyPieChart() {
	/*
	 * EASY PIE CHARTS
	 * DEPENDENCY: js/plugins/easy-pie-chart/jquery.easy-pie-chart.min.js
	 * Usage: <div class="easy-pie-chart txt-color-orangeDark" data-pie-percent="33" data-pie-size="72" data-size="72">
	 *			<span class="percent percent-sign">35</span>
	 * 	  	  </div>
	 */


		$('.easy-pie-chart').each(function() {
			var $this = $(this),
				barColor = $this.css('color') || $this.data('pie-color'),
			    trackColor = $this.data('pieTrackColor') || 'rgba(0,0,0,0.04)',
			    linewidth = ( parseInt($this.data('pie-linewidth')) || parseInt($this.data('pie-size')) ) || 25;
			    size = parseInt($this.data('pie-size')) || 25;

			
			new EasyPieChart(this, {
				
				barColor : barColor,
				trackColor : trackColor,
				scaleColor : false,
				lineCap : 'butt',
				lineWidth : parseInt(linewidth / 8.5),
				animate : 1500,
				rotate : -90,
				size : size,
				onStep: function(from, to, percent) {
        			$(this.el).find('.percent').text(Math.round(percent));
    			}
				
			});
			
			$this = null;
		});


}



function runAllCharts() {
	applyEasyPieChart();
	applySparkline();
}

runAllCharts();



$("a[data-chat-id]:not(.offline)").click(function(a, b) {
    var c = $(this)
      , d = c.attr("data-chat-id")
      , e = c.attr("data-chat-fname")
      , f = c.attr("data-chat-lname")
      , g = c.attr("data-chat-status") || "online"
      , h = c.attr("data-chat-alertmsg")
      , i = c.attr("data-chat-alertshow") || !1;
    chatboxManager.addBox(d, {
        "title": "username" + d,
        "first_name": e,
        "last_name": f,
        "status": g,
        "alertmsg": h,
        "alertshow": i
    }),
    a.preventDefault()
});





// demo 

function applyTheme (element) {
    var a = $(element)
      , b = $(".sa-logo");
    $.root_.removeClassPrefix("smart-style").addClass(a.attr("id")),
    $("html").removeClassPrefix("smart-style").addClass(a.attr("id")),
    b.attr("src", a.data("skinlogo")),
    $("#smart-styles > a #skin-checked").remove(),
    a.prepend("<i class='fa fa-check fa-fw' id='skin-checked'></i>")	
}
$("#smart-styles > a").on("click", function() {
	applyTheme(this);
});









/*
 * INITIALIZE JARVIS WIDGETS
 * Setup Desktop Widgets
 */
	function setup_widgets_desktop() {
	
		if ($.fn.jarvisWidgets && enableJarvisWidgets) {
	
			$('#widget-grid').jarvisWidgets({
	
				grid : 'article',
				widgets : '.jarviswidget',
				localStorage : localStorageJarvisWidgets,
				deleteSettingsKey : '#deletesettingskey-options',
				settingsKeyLabel : 'Reset settings?',
				deletePositionKey : '#deletepositionkey-options',
				positionKeyLabel : 'Reset position?',
				sortable : sortableJarvisWidgets,
				buttonsHidden : false,
				// toggle button
				toggleButton : true,
				toggleClass : 'fa fa-minus | fa fa-plus',
				toggleSpeed : 200,
				onToggle : function() {
				},
				// delete btn
				deleteButton : true,
				deleteMsg:'Warning: This action cannot be undone!',
				deleteClass : 'fa fa-times',
				deleteSpeed : 200,
				onDelete : function() {
				},
				// edit btn
				editButton : true,
				editPlaceholder : '.jarviswidget-editbox',
				editClass : 'fa fa-cog | fa fa-save',
				editSpeed : 200,
				onEdit : function() {
				},
				// color button
				colorButton : true,
				// full screen
				fullscreenButton : true,
				fullscreenClass : 'fa fa-expand | fa fa-compress',
				fullscreenDiff : 3,
				onFullscreen : function() {
				},
				// custom btn
				customButton : false,
				customClass : 'folder-10 | next-10',
				customStart : function() {
					alert('Hello you, this is a custom button...');
				},
				customEnd : function() {
					alert('bye, till next time...');
				},
				// order
				buttonOrder : '%refresh% %custom% %edit% %toggle% %fullscreen% %delete%',
				opacity : 1.0,
				dragHandle : '> header',
				placeholderClass : 'jarviswidget-placeholder',
				indicator : true,
				indicatorTime : 600,
				ajax : true,
				timestampPlaceholder : '.jarviswidget-timestamp',
				timestampFormat : 'Last update: %m%/%d%/%y% %h%:%i%:%s%',
				refreshButton : true,
				refreshButtonClass : 'fa fa-refresh',
				labelError : 'Sorry but there was a error:',
				labelUpdated : 'Last Update:',
				labelRefresh : 'Refresh',
				labelDelete : 'Delete widget:',
				afterLoad : function() {
				},
				rtl : false, // best not to toggle this!
				onChange : function() {
					
				},
				onSave : function() {
					
				},
				ajaxnav : $.navAsAjax // declears how the localstorage should be saved (HTML or AJAX Version)
	
			});
	
		}
	
	}
/*
 * SETUP DESKTOP WIDGET
 */
setup_widgets_desktop();

/* ~ END: INITIALIZE JARVIS WIDGETS */




$(".sa-logout-header-toggle").click(function(t) {
    var a = $(this);
    userLogout(a);
    t.preventDefault();
    a = null;
})

$('[data-action="userLogout"]').click(function(t) {
    var a = $(this);
    userLogout(a);
    t.preventDefault();
    a = null;
})


function userLogout(e) {
    function t() {
        window.location = e.attr("href")
    }
    $.SmartMessageBox({
        title: "<i class='fa fa-sign-out text-orange-dark'></i> Logout <span class='text-orange-dark'><strong>" + $(".sa-sidebar-shortcut-toggle").text() + "</strong></span> ?",
        content: e.data("logout-msg") || "You can improve your security further after logging out by closing this opened browser",
        buttons: "[No][Yes]"
    }, function(e) {
        "Yes" == e && ($.root_.addClass("animated fadeOutUp"),
        setTimeout(t, 1e3))
    })
}



$('[data-rel="popover-hover"]').popover();
$('[rel="tooltip"]').tooltip();
$('[data-action="toggleMenu"]').click(function(){
	$('body').removeClass('minified');
	SAtoggleClass(this, 'body', 'sa-hidden-menu')
});

$('[data-action="minifyMenu"]').click(function(){
	$('body').removeClass('sa-hidden-menu');
	SAtoggleClass(this, 'body', 'minified')
});

$('[data-action="toggleShortcut"]').click(function(){
	SAtoggleClass(this, 'body', 'sa-shortcuts-expanded')
});


$('[data-action="launchFullscreen"]').click(function(){
	toggleFullScreen()
});

$('[data-action="resetWidgets"]').click(function(){
	smartadmin.resetWidgets($(this));
});

$('[data-toggle="popover"]').popover();

if ($.fn.datepicker) {
	$('.datepicker').each(function() {

		var $this = $(this),
			dataDateFormat = $this.attr('data-dateformat') || 'dd.mm.yy';

		$this.datepicker({
			dateFormat : dataDateFormat,
			prevText : '&#xf053;',
			nextText : '&#xf054;',
		});
		
		//clear memory reference
		$this = null;
})
}


if ($.fn.barrating) {
	$('.barrating').each(function() {

		var $this = $(this);

		$this.barrating({
			theme: 'fontawesome-stars'
		});
		
		//clear memory reference
		$this = null;
	});
}


$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
    _title: function(title) {
        if (!this.options.title ) {
            title.html("&#160;");
        } else {
            title.html(this.options.title);
        }
    }
}));


/*
 * INITIALIZE FORMS
 * Description: Select2, Masking, Datepicker, Autocomplete
 */	
function runAllForms() {

	/*
	 * BOOTSTRAP SLIDER PLUGIN
	 * Usage:
	 * Dependency: js/plugin/bootstrap-slider
	 */
	if ($.fn.slider) {
		$('.slider').bootstrapSlider();
	}

	/*
	 * SELECT2 PLUGIN
	 * Usage:
	 * Dependency: js/plugin/select2/
	 */
	if ($.fn.select2) {
		$('select.select2').each(function() {
			var $this = $(this),
				width = $this.attr('data-select-width') || '100%';
			//, _showSearchInput = $this.attr('data-select-search') === 'true';
			$this.select2({
				//showSearchInput : _showSearchInput,
				allowClear : true,
				width : width
			});

			//clear memory reference
			$this = null;
		});
	}

	/*
	 * MASKING
	 * Dependency: js/plugin/masked-input/
	 */
	if ($.fn.mask) {
		$('[data-mask]').each(function() {

			var $this = $(this),
				mask = $this.attr('data-mask') || 'error...', mask_placeholder = $this.attr('data-mask-placeholder') || 'X';

			$this.mask(mask, {
				placeholder : mask_placeholder
			});
			
			//clear memory reference
			$this = null;
		});
	}

	/*
	 * AUTOCOMPLETE
	 * Dependency: js/jqui
	 */
	if ($.fn.autocomplete) {
		$('[data-autocomplete]').each(function() {

			var $this = $(this),
				availableTags = $this.data('autocomplete') || ["The", "Quick", "Brown", "Fox", "Jumps", "Over", "Three", "Lazy", "Dogs"];

			$this.autocomplete({
				source : availableTags
			});
			
			//clear memory reference
			$this = null;
		});
	}

	/*
	 * JQUERY UI DATE
	 * Dependency: js/libs/jquery-ui-1.10.3.min.js
	 * Usage: <input class="datepicker" />
	 */
	if ($.fn.datepicker) {
		$('.datepicker').each(function() {

			var $this = $(this),
				dataDateFormat = $this.attr('data-dateformat') || 'dd.mm.yy';

			$this.datepicker({
				dateFormat : dataDateFormat,
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
			});
			
			//clear memory reference
			$this = null;
		});
	}

	/*
	 * AJAX BUTTON LOADING TEXT
	 * Usage: <button type="button" data-loading-text="Loading..." class="btn btn-xs btn-default ajax-refresh"> .. </button>
	 */
	$('button[data-loading-text]').on('click', function() {
		var btn = $(this);
		btn.button('loading');
		setTimeout(function() {
			btn.button('reset');
			//clear memory reference
			btn = null;
		}, 3000);

	});

}



/*
 * GOOGLE MAPS
 * description: Append google maps to head dynamically (only execute for ajax version)
 * Loads at the begining for ajax pages
 */
	if ($.navAsAjax || $(".google_maps")){
		var gMapsLoaded = false;
		window.gMapsCallback = function() {
			gMapsLoaded = true;
			$(window).trigger('gMapsLoaded');
		};
		window.loadGoogleMaps = function() {
			if (gMapsLoaded)
				return window.gMapsCallback();
			var script_tag = document.createElement('script');
			script_tag.setAttribute("type", "text/javascript");
			script_tag.setAttribute("src", "https://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback");
			(document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
		};
	}
/* ~ END: GOOGLE MAPS */

//setTimeout(function(){
//	applyTheme('#smart-style-6');
//});
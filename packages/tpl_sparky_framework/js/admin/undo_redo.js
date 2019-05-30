/*Undo redo functionality*/

var undo = new Array();
var redo = new Array();
var maxChanges = 29;
var max_show=5;
var object;
var objectLayoutSet = false;	

var current_menu="";

setTimeout(function(){
	if(jQuery("#jform_params_undo").val()!="" || jQuery("#jform_params_redo").val()!=""){
	try{
		if(jQuery("#jform_params_undo").val()!="" )
			undo = JSON.parse(jQuery("#jform_params_undo").val());
		if(jQuery("#jform_params_redo").val()!="" )
			redo = JSON.parse(jQuery("#jform_params_redo").val());
		tooltip_refresh();
		
	}
	catch(err){
		
	}		
}
},200);

function tooltip_refresh(){
	if(undo.length>0){
	
		jQuery("#toolbar-undo button").attr("data-original-title",undo[undo.length-1].label);
	}
	else{
		jQuery("#toolbar-undo button").attr("data-original-title","Nothing to undo");
	}
	if(redo.length>0){

		jQuery("#toolbar-redo button").attr("data-original-title",redo[redo.length-1].label);
	}
	else{
		jQuery("#toolbar-redo button").attr("data-original-title","Nothing to redo");
	}
};

function resetStack(){
	undo = [];
	redo = [];
	jQuery("#jform_params_undo").val("");
	jQuery("#jform_params_redo").val("");
};

function pushObjectLayout(){
		var label = "Layout change";		
		var type= "layout";
		if(!objectLayoutSet)
		    object = jQuery("#jform_params_layoutdesign").val();	
		objectLayoutSet =  false;
		var tab = jQuery('#tadmin_menu .ui-state-active').attr("aria-controls");
		var subTab = "";
		var tabs = jQuery("[role='tabpanel']");
		
		for(var i=0;i<tabs.length;i++){
			if(jQuery(tabs[i]).css('display') == 'block'){
				subTab=jQuery(tabs[i]).find('.subtab_menu_item.ui-state-active').attr('id');
				if(subTab=="undefined")
					subTab="";
					
				break;	
			}
		}
		var parameter = "";
		var id="";
		var oldVal="";
		var obj = {
			'parameter' : parameter,
			'tab':tab,
			'subTab':subTab,
			'id':id,
			'oldVal':oldVal,
			'type':type,
			'obj' : object,
			'label': label
		};
		
		/*REAL UNDO REDO LIKE IN MS OFFICE*/
		if(undo.length == 0){
			redo = [];
		}
			
		if(undo.length > maxChanges){
				undo.shift();
				undo.push(obj);
		}
		else
			undo.push(obj);
		
		jQuery("#jform_params_undo").val(JSON.stringify(undo));
		
		tooltip_refresh();
		
	};

jQuery(document).ready(function(){
	
	jQuery("#toolbar-undo button,#toolbar-redo button").attr("data-toggle","tooltip");
	jQuery("#toolbar-undo button").attr("data-title","Undo steps");
	jQuery("#toolbar-redo button").attr("data-title","Redo steps");
	jQuery("#toolbar-undo button").attr("onclick","");
	jQuery("#toolbar-redo button").attr("onclick","");

	
	setTimeout(function(){
		jQuery("[data-toggle='tooltip']").tooltip({
			delay: { show: 500, hide: 0 },
			placement: 'bottom',
			trigger: 'hover',
			html: true
		});
	},100);

	var color = 0;
	var colorMenu = 0;
	var changes = new Array();
	
	var type;
	var label;

	var images ={};
	var oldVal;
	var parameter = false;
	
	var currentClick = true;
	var currentCheck = true;
	var currentToggle = true;
	var currentPrepend = true;
	var iz_menija = false;
	var imagesObj = jQuery(".input-prepend.input-append input");
	
	/*Images array, remembers filenames at start*/
	for(var i=0; i< imagesObj.length;i++){
		images[jQuery(imagesObj[i]).attr("id")]=jQuery(imagesObj[i]).val();
	}
	
	jQuery(document).on('click','#toolbar-undo button', function(){
		
		once = false;
		
		//undo action - retrive last change, change it state and remove it from undo - insert into redo
		if(undo.length){
			var last = undo.pop();
			jQuery("#jform_params_undo").val(JSON.stringify(undo));
		
				var newVal = false;
				jQuery("a[href='#"+last.tab+"']").click();
				jQuery("#"+last.subTab+"").click();
				
				if(last.type=="input" || last.type=="prepend_append"){
					if(last.parameter){
						newVal=jQuery(last.obj).val();
						jQuery(last.obj).val(last.oldVal);
						jQuery(last.obj).parent('.menusSettingsContainer').click();
					}
					else{
						newVal = jQuery("#"+last.id+"").val();
						jQuery("#"+last.id+"").val(last.oldVal);
					}
				}
				else if(last.type=="select"){
					if(last.parameter){
						newVal = jQuery(this).find("option[selected='selected']").val();
						jQuery(last.obj).find("option:selected").attr("selected",false);
						jQuery(last.obj).find("option[value='"+last.oldVal+"']").attr("selected",true);
						jQuery(last.obj).trigger("liszt:updated");
					}
					else{
						newVal = jQuery("#"+last.id+"_chzn").find('span').text().toLowerCase();
						jQuery("#"+last.id+" option:selected").attr("selected",false);
						jQuery("#"+last.id+" option").filter(function () { return jQuery(this).html().toLowerCase() == last.oldVal; }).attr("selected",true);
						jQuery("#"+last.id+"").trigger("liszt:updated");
					}	
				}
				else if(last.type=="flip"){
					if(last.parameter){
						//newVal = jQuery(last.obj).prev('input').val();
						//jQuery(last.obj).prev('input').val(last.oldVal);
						currentClick  = false;
						jQuery(last.obj).find("li").click();
					}
					else{
						//newVal = jQuery("#"+last.id+"").val();
						//jQuery("#"+last.id+"").val(last.oldVal);
						currentClick  = false;
						jQuery("#"+last.id+"").parent().find("ul li").click();
					}
					newVal=true;
				}
				else if(last.type=="checkbox"){
					currentCheck  = false;
					jQuery("#"+last.id+"").click();
					newVal=true;
				}
				else if(last.type=="toggle_button"){
					currentToggle = false;
					jQuery(last.obj).click();
					newVal = true;
				}
				else if(last.type=="menucfg"){
					/*Pasted from mnucfg.php*/
					var vals1 = last.obj;
					
					for(var i=0; i< current.length; i++){
						if(current[i]['name']==vals1['name'])
						{
							last.obj = current[i];
							break;
						}
					}

					var mnu       = vals1['name'];
					var mnu_val   = vals1['type'];
					if(mnu_val == "") mnu_val = "standard";

					var fobject = jQuery('#mnupaneljform_params_mnucfg select[menu="' + mnu + '"]');
					fobject.val(mnu_val);
					if(!jQuery("select[menu='"+mnu+"']").parent().prev().hasClass('opentab'))
						jQuery("select[menu='"+mnu+"']").parent().prev().click();
					window.loadMenuPaneljform_params_mnucfg(fobject,mnu_val,vals1['config']);
					newVal=true;
					
				}
				else if(last.type=="layout"){
					window.load_layoutjform_params_layoutdesign(last.obj);
					last.obj=jQuery("#jform_params_layoutdesign").val();
					newVal=true;
				}
				else if(last.type=="color"){
					newVal = jQuery("#"+last.id+"").val();
					jQuery("#"+last.id+"").val(last.oldVal).css("backgroundColor",last.oldVal);
					jQuery("#"+last.id+"").css("color",getContrastYIQ(last.oldVal));
					
				}
				else if(last.type=="gfont_change"){
						var for_parse = jQuery("#"+last.id).val();
						for_parse = for_parse.replace(/\\'/g,"'");
						newVal = for_parse;
						var old = last.oldValLabel;
						last.oldValLabel = jQuery("#"+last.id).prev().val();
						jQuery("#"+last.id).prev().val(old);
						jQuery("#"+last.id).prev().attr("data-original-title", old);
						jQuery("#"+last.id).val(last.oldVal);
				}else if(last.type=="sfont_change"){
						var for_parse = jQuery("#"+last.id).val().replace(/\\'/g, "\'");
						for_parse = for_parse.replace(/\\'/g, "\'");
						newVal = for_parse;
						var old = last.oldValLabel;
						last.oldValLabel = jQuery("#"+last.id).prev().val();
						jQuery("#"+last.id).prev().val(old);
						jQuery("#"+last.id).prev().attr("data-original-title", old);
						jQuery("#"+last.id).val(last.oldVal);
				}
				
				last.oldVal=newVal;
				if(newVal){
					if(redo.length > maxChanges){
							redo.shift();
							redo.push(last);
					}
					else
						redo.push(last);
				}
			
				jQuery("#jform_params_redo").val(JSON.stringify(redo));
		}
		
		tooltip_refresh();
		jQuery("#toolbar-undo button").tooltip('fixTitle').tooltip('show');
		SqueezeBox.initialize({});
		SqueezeBox.assign(jQuery('a.modal').get(), {
			parse: 'rel'
		});
		
		window.mini_settings();
	});
	jQuery(document).on('click','#toolbar-redo button', function(){
		//redo action - retrive last redo action change is state and insert into undo
		
		once = false;
		if(redo.length){
			
			var last = redo.pop();
			
			jQuery("#jform_params_redo").val(JSON.stringify(redo));
			
			jQuery("a[href='#"+last.tab+"']").click();
			jQuery("#"+last.subTab+"").click();
			var newVal = false;
			if(last.type=="input" || last.type=="prepend_append"){
					if(last.parameter){
						newVal=jQuery(last.obj).val();
						jQuery(last.obj).val(last.oldVal);
					}
					else{
						newVal = jQuery("#"+last.id+"").val();
						jQuery("#"+last.id+"").val(last.oldVal);
					}
				}
			else if(last.type=="select"){
					if(last.parameter){
						newVal = jQuery(this).find("option[selected='selected']").val();
						jQuery(last.obj).find("option:selected").attr("selected",false);
						jQuery(last.obj).find("option[value='"+last.oldVal+"']").attr("selected",true);
						jQuery(last.obj).trigger("liszt:updated");
					}
					else{
						newVal = jQuery("#"+last.id+"_chzn").find('span').text().toLowerCase();
						jQuery("#"+last.id+" option:selected").attr("selected",false);
						jQuery("#"+last.id+" option").filter(function () { return jQuery(this).html().toLowerCase() == last.oldVal; }).attr("selected",true);
						jQuery("#"+last.id+"").trigger("liszt:updated");
					}	
				}
				else if(last.type=="flip"){
					if(last.parameter){
						//newVal = jQuery(last.obj).prev('input').val();
						//jQuery(last.obj).prev('input').val(last.oldVal);
						currentClick  = false;
						jQuery(last.obj).find("li").click();
					}
					else{
						//newVal = jQuery("#"+last.id+"").val();
						//jQuery("#"+last.id+"").val(last.oldVal);
						currentClick  = false;
						jQuery("#"+last.id+"").parent().find("ul li").click();
					}
					newVal=true;
				}
				else if(last.type=="checkbox"){
					currentCheck  = false;
					jQuery("#"+last.id+"").click();
					newVal=true;
				}
				else if(last.type=="toggle_button"){
					currentToggle = false;
					jQuery(last.obj).click();
					newVal = true;
				}
				else if(last.type=="menucfg"){
					/*Pasted from mnucfg.php*/
					var vals1 = last.obj;
					
					for(var i=0; i< current.length; i++){
						if(current[i]['name']==vals1['name'])
						{
							last.obj = current[i];
							break;
						}
					}

					var mnu       = vals1['name'];
					var mnu_val   = vals1['type'];
					if(mnu_val == "") mnu_val = "standard";

					var fobject = jQuery('#mnupaneljform_params_mnucfg select[menu="' + mnu + '"]');
					fobject.val(mnu_val);
					if(!jQuery("select[menu='"+mnu+"']").parent().prev().hasClass('opentab'))
						jQuery("select[menu='"+mnu+"']").parent().prev().click();
					window.loadMenuPaneljform_params_mnucfg(fobject,mnu_val,vals1['config']);
					newVal=true;
					
				}
				else if(last.type=="layout"){
					window.load_layoutjform_params_layoutdesign(last.obj);
					last.obj=jQuery("#jform_params_layoutdesign").val();
					newVal=true;
				}
				else if(last.type=="color"){
					newVal = jQuery("#"+last.id+"").val();
					jQuery("#"+last.id+"").val(last.oldVal).css("backgroundColor",last.oldVal);
					jQuery("#"+last.id+"").css("color",getContrastYIQ(last.oldVal));
				}
				else if(last.type=="gfont_change"){
						var for_parse = jQuery("#"+last.id).val();
						for_parse = for_parse.replace(/\\'/g,"'");
						newVal = for_parse;
						var old = last.oldValLabel;
						last.oldValLabel = jQuery("#"+last.id).prev().val();
						jQuery("#"+last.id).prev().val(old);
						jQuery("#"+last.id).prev().attr("data-original-title", old);
						jQuery("#"+last.id).val(last.oldVal);
				}else if(last.type=="sfont_change"){
						var for_parse = jQuery("#"+last.id).val().replace(/\\'/g, "\'");
						for_parse = for_parse.replace(/\\'/g, "\'");
						newVal = for_parse;
						var old = last.oldValLabel;
						last.oldValLabel = jQuery("#"+last.id).prev().val();
						jQuery("#"+last.id).prev().val(old);
						jQuery("#"+last.id).prev().attr("data-original-title", old);
						jQuery("#"+last.id).val(last.oldVal);
				}
				
			
			last.oldVal=newVal;
			if(newVal)
				undo.push(last);	
			
			jQuery("#jform_params_undo").val(JSON.stringify(undo));
			
		}
		tooltip_refresh();
		jQuery("#toolbar-redo button").tooltip('fixTitle').tooltip('show');
		SqueezeBox.initialize({});
		SqueezeBox.assign(jQuery('a.modal').get(), {
			parse: 'rel'
		});
		window.mini_settings();
	});
	
	function getContrastYIQ(hexcolor){
		var r = parseInt(hexcolor.substr(1,2),16);
		var g = parseInt(hexcolor.substr(3,2),16);
		var b = parseInt(hexcolor.substr(5,2),16);
		var yiq = ((r*299)+(g*587)+(b*114))/1000;
		return (yiq >= 128) ? 'black' : 'white';
	}
	
	/*Push object to undo array*/
	function pushObject(event){
		
		var id = "";
		if(event.data.tmp=="menucfg" || event.data.tmp=="menucfg-color"){	
			event.stopImmediatePropagation();	
			if(event.data.tmp=="menucfg-color"){
				
				colorMenu++;
				if(colorMenu==2){
					colorMenu=0;
					return;
				}
			}
			label = "Menu settings";	
			type= "menucfg";
			if(!iz_menija){
				for(var i=0; i< current.length; i++){
					if(current[i]['name']==current_menu)
					{
						object = current[i];
						break;
					}
				}
			}
			iz_menija = false;
		}else if(event.data.tmp=="fonts"){
			
		}
		else{
			if(type == "prepend_append" || event.data.tmp=="change"){
				id = jQuery(this).attr("id"); 
			}
			else if(event.data.tmp=="button"){
				if(currentToggle){
					label = jQuery(this).text();
					object = jQuery(this);
					type = "toggle_button";
				}
				else{
					currentToggle = true;
					return;
				}
			}
			else
				id = event.attr("id");
			
			if(typeof id === 'undefined' && parameter==false)
				return;
		
			if(typeof id !== 'undefined'){
				if(!(type=="flip" && typeof jQuery(this).parent().attr("id")=== 'undefined'))
					parameter=false;
			}			
		}
		
		var tab = jQuery('#tadmin_menu .ui-state-active').attr("aria-controls");
		var subTab = "";
		var tabs = jQuery("[role='tabpanel']");
		
		for(var i=0;i<tabs.length;i++){
			if(jQuery(tabs[i]).css('display') == 'block'){
				subTab=jQuery(tabs[i]).find('.subtab_menu_item.ui-state-active').attr('id');
				if(subTab=="undefined")
					subTab="";
					
				break;	
			}
		}
	
		var obj = {
			'parameter' : parameter,
			'tab':tab,
			'subTab':subTab,
			'id':id,
			'oldVal':oldVal,
			'type':type,
			'obj' : object,
			'label': label
		};
		
		/*REAL UNDO REDO LIKE IN MS OFFICE*/
		if(undo.length == 0){
			redo = [];
		}
			
		if(undo.length > maxChanges){
				undo.shift();
				undo.push(obj);
		}
		else
			undo.push(obj);
		
		iz_menija = false;
		jQuery("#jform_params_undo").val(JSON.stringify(undo));
		
		tooltip_refresh();
		label = "Action";
	};
	
	/*Writes data for text input*/
	function writeData(e){
		e.stopPropagation();
		if(jQuery(this).hasClass('chk-menulink')){
			type= "checkbox";
			if(currentCheck){
				label= jQuery(this).parent().text();
				pushObject(jQuery(this));
			}
			else{
				currentCheck=true;
			}
			return;
		}
		else
			type = "input";
		
		var attr = jQuery(this).attr("id");
		label = jQuery("label[for='"+jQuery(this).attr('id')+"']").text();
		if((typeof attr == typeof undefined || attr == false) && iz_menija==false){
			
			for(var i=0; i< current.length; i++){
				if(current[i]['name']==current_menu)
				{
					object = current[i];
					break;
				}
			}
			label = jQuery(this).prev().text();
			iz_menija = true;
		}
		else{
			iz_menija = false;
		}
		
		oldVal = jQuery(this).val();	
	};
	
	function writeDataColor(e){
		//added for layout settings
		if(jQuery(this).parents('.no_undo').length)
			return;
		color++;
		e.stopImmediatePropagation();
		label = jQuery("label[for='"+jQuery(this).attr('id')+"']").text();
		type = "color";
		oldVal = jQuery(this).val();
		if(color==2){
			color=0;
		}
		else
			pushObject(jQuery(this));
		
	};

	/*Writes data for select bar*/
	function writeDataCzn(e){
		e.stopPropagation();
		type = "select";
		var attr = jQuery(this).attr("id");
		if(!(typeof attr !== typeof undefined && attr !== false)){
			jQuery(this).trigger("liszt:updated");
			parameter = jQuery(this).attr("parameter");
			object = jQuery(this);
			oldVal = jQuery(this).find("option[selected='selected']").val();
		}
		else{
			oldVal = jQuery(this).find('span').text().toLowerCase();
			label = jQuery("label[for='"+jQuery(this).attr('id').substring(0,jQuery(this).attr('id').length-5)+"']").text();
		}
		

	};
	
	/*Writes data for flip*/
	function writeDataFlip(e){
		e.stopImmediatePropagation();
		//added for layout settings
		if(jQuery(this).parents('.no_undo').length)
			return;
		if(currentClick){
			type = "flip";
			oldVal = "";
			object = jQuery(this).parent();
			parameter = jQuery(object).prev('input').attr("parameter");
			if(typeof parameter !== typeof undefined){
				label = jQuery(object).prev('input').prev().text();
			}
			else{
				label = jQuery("label[for='"+jQuery(this).parent().prev().attr('id')+"']").text();
			}
			pushObject(object);
		}else{
			currentClick = !currentClick;
		}
	};
	
	/*Writes data for images bar*/
	function writeDataPrependAppend(e){
		e.stopPropagation();
		type="prepend_append";
		label = jQuery("label[for='"+jQuery(this).attr('id')+"']").text();
		oldVal=images[jQuery(this).attr("id")];
		images[jQuery(this).attr("id")] = jQuery(this).val();
		pushObject(jQuery(this));
	};
	
	function writeDataGFonts(e){
		label = "Font Change";
		type="gfont_change";
		var for_parse = jQuery(this).prev().prev().val();
		for_parse = for_parse.replace(/\\'/g,"'");
		oldValLabel= jQuery(this).parent().find('input[type="text"]').val();
		oldVal = for_parse;
		id = jQuery(this).siblings("input[type='hidden']").attr("id");
		
	};
	function writeDataSFonts(e){
		label = "Font Change";
		type="sfont_change";
		var for_parse = jQuery(this).prev().val().replace(/\\'/g, "\'");
		for_parse = for_parse.replace(/\\'/g, "\'");
		oldVal = for_parse;
		oldValLabel= jQuery(this).parent().find('input[type="text"]').val();
		id = jQuery(this).prev().attr("id");
	};
	
	function pushFontObject(){
		var tab = jQuery('#tadmin_menu .ui-state-active').attr("aria-controls");
		var subTab = "";
		var tabs = jQuery("[role='tabpanel']");
		
		for(var i=0;i<tabs.length;i++){
			if(jQuery(tabs[i]).css('display') == 'block'){
				subTab=jQuery(tabs[i]).find('.subtab_menu_item.ui-state-active').attr('id');
				if(subTab=="undefined")
					subTab="";
					
				break;	
			}
		}
		var obj = {
			'parameter' : parameter,
			'tab':tab,
			'subTab':subTab,
			'id':id,
			'oldVal':oldVal,
			'oldValLabel': oldValLabel,
			'type':type,
			'obj' : object,
			'label': label
		};
		
		/*REAL UNDO REDO LIKE IN MS OFFICE*/
		if(undo.length == 0){
			redo = [];
		}
			
		if(undo.length > maxChanges){
				undo.shift();
				undo.push(obj);
		}
		else
			undo.push(obj);
		
		jQuery("#jform_params_undo").val(JSON.stringify(undo));
		
		tooltip_refresh();
	};
	
	jQuery(document).on('change',"input.layoutrow_name, input.layoutrow_class",function(e){
		e.stopImmediatePropagation();
		pushObjectLayout();
	});
	
	jQuery(document).on('change',"#mnupaneljform_params_mnucfg select,#mnupaneljform_params_mnucfg input,#mnupaneljform_params_mnucfg textarea",{tmp: 'menucfg'}, function(e){	 
		pushObject(e);
		window.lastsaveMenuParmsTime = 0;
		window.save_menu_cfg_fn();
	});
	
	jQuery(document).on('change','.input-prepend.input-append:not(.font) input',writeDataPrependAppend);
	jQuery(document).on('change','.container-main select',{tmp: 'change'}, pushObject);
	jQuery(document).on('change',".container-main input[type='text']:not('.font, .fontlbl'), .container-main input[type='number'], .container-main textarea",{tmp: 'change'}, pushObject);
	
	
	jQuery(document).on('click','input.layoutrow_name, input.layoutrow_class',function(e){
		e.stopImmediatePropagation();
		object = jQuery("#jform_params_layoutdesign").val();
		objectLayoutSet = true;
	});
	jQuery(document).on('click','.container-main .chzn-container.chzn-with-drop, .menusSettingsContainer select', writeDataCzn);
	jQuery(document).on('click',".container-main input:not('.font, .fontlbl')", writeData);
	jQuery(document).on('click','#assignment button.btn',{tmp: 'button'},pushObject);
	jQuery(document).on('click','#mnupaneljform_params_mnucfg .flipyesno li',{tmp: 'menucfg'}, pushObject);
	jQuery(document).on('click','.flipyesno li', writeDataFlip);
	
	jQuery(document).on('blur',"#mnupaneljform_params_mnucfg input.pckcolor",{tmp: 'menucfg-color'}, pushObject);
	jQuery(document).on('blur',"input.pckcolor",writeDataColor);
	
	jQuery(document).on('focus',".container-main input[type='number'], .container-main textarea", writeData);
	jQuery(document).on('click',".container-main input[type='number']", writeData);
	
	jQuery(document).on('mousedown',".container-main .system", writeDataSFonts);
	jQuery(document).on('mousedown',".container-main .google", writeDataGFonts);
	
	jQuery(document).on('change',".container-main input.fontlbl", pushFontObject);
	
	jQuery(document).on('change',"#jform_params_layoutdesign", pushObjectLayout);
	
	jQuery(document).on('hover',".menusSettingsContainer", function(){
		current_menu=jQuery(this).find('select').first().attr('menu');
	});
	
	
});
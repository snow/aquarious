function loadJS(filename){
	var str = '<script src="' + filename + '" type="text/javascript"></script>';
	$('head').append(str);
}
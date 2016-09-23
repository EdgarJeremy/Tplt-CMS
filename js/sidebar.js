/* Sidebar */

$(document).ready(function(){
	var keberita = $("#keberita"),
		berita = $("#berita"),
		kegallery = $("#kegallery");
		gallery = $("#gallery");
		keagenda = $("#keagenda"),
		agenda = $("#agenda"),
		ketema = $("#ketema"),
		tema = $("#tema");
	
	keberita.on("click",function(){
		berita.slideToggle(300);
		agenda.slideUp(300);
		tema.slideUp(300);
		gallery.slideUp(300);
	});
	
	kegallery.on("click",function() {
		berita.slideUp(300);
		agenda.slideUp(300);
		tema.slideUp(300);
		gallery.slideToggle(300);
	});
	
	keagenda.on("click",function(){
		agenda.slideToggle(300);
		berita.slideUp(300);
		tema.slideUp(300);
		gallery.slideUp(300);
	});
	
	ketema.on("click",function(){
		tema.slideToggle(300);
		agenda.slideUp(300);
		berita.slideUp(300);
		gallery.slideUp(300);
	});
	
});
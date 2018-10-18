$(function() {
 //导航载入
		$.ajax({
		type:"get",
		url:"header.html",
		dataType:"html",
		async:false,
		success:function(data){
		$("#top-header").append(data);
		}
		});

        $.ajax({
		type:"get",
		url:"footer.html",
		dataType:"html",
		async:false,
		success:function(data){
		$("#bottom-footer").append(data);
		}
		});
		
	
})

function tourl(url){
	if(url == ''){
		return;
	}
	window.open(url);

}
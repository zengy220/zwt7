//yyyy-MM-dd HH:mm:ss
function change_picktime(date){
		if (date){
		WdatePicker({dateFmt:''+date+''});
		}else{
			WdatePicker();
		}
}	

//删除数据
function del_data(id,url){
if(confirm('确定删除吗 ？')){
window.location.href=url+id;
}
}
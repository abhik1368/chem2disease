function getSuggestions(value){
			if (value!=""){ 
			$.post("content.php",{content:value},function(data){
				$("#suggestions").html(data);
				doCSS();
			});
			}else{
				
				$("#suggestions").html("");
				undoCSS();
				}
		}
		function removeSuggestions(){
			$("#suggestions").html("");
			undoCSS();
			
			}
		
		
		function addText(value){
		 
		    $("#srch_for").val(value);
		 	
		}
		
		function doCSS(){
			$("#suggestions").css({
				'border':'solid',
				'border-width':'1px'});
			  
			
			}
			
		function undoCSS(){
			$("#suggestions").css({
				'border':'',
				'border-width':''});
			
			}	

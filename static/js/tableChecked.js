function Kin_Tables(Kin_Table_GetTableMethod, //get your table
		Kin_Table_Header_Offset, //set the table header offset
		Kin_Table_Footer_Offset, //set the table footer offset
		Kin_Table_Odd_Style, // set the table odd row style name (Default:odd)
		Kin_Table_Even_Style, // set the table even row style name (Default:even)
		Kin_Table_Hover_Style, // set the table mouseover row style name (Default:over)
		Kin_Table_Click_Style // set the table odd row style name (Default:clicked)
    ){

        $(function(){
            var Kin_Table_Config = [];
            Kin_Table_Config.GetTableMethod = (Kin_Table_GetTableMethod ? Kin_Table_GetTableMethod : ".Kin_Table"); //得到Table的方法 同$() 必选
            Kin_Table_Config.Header_Offset = (!isNaN(Kin_Table_Header_Offset) ? Kin_Table_Header_Offset : 0); //从前起忽略多少行 可选参数
            Kin_Table_Config.Footer_Offset = (!isNaN(Kin_Table_Footer_Offset) ? Kin_Table_Footer_Offset : 0); //从后起忽略多少行 可选参数
            Kin_Table_Config.Odd_Style = (Kin_Table_Odd_Style ? Kin_Table_Odd_Style : "row1"); //奇数行样式 可选参数
            Kin_Table_Config.Even_Style = (Kin_Table_Even_Style ? Kin_Table_Even_Style : "row2"); //偶数行样式 可选参数
            Kin_Table_Config.Hover_Style = (Kin_Table_Hover_Style ? Kin_Table_Hover_Style : "hover"); //鼠标悬停样式 可选参数
            Kin_Table_Config.Click_Style = (Kin_Table_Click_Style ? Kin_Table_Click_Style : "click"); //鼠标点击样式 可选参数

            //var Kin_Table = $(Kin_Table_Config.GetTableMethod+" tr:nth-child(n+"+eval(Kin_Table_Config.Header_Offset+1)+")"); //Old Method
            var Kin_Table = $(Kin_Table_Config.GetTableMethod + " tr").slice(Kin_Table_Config.Header_Offset,-Kin_Table_Config.Footer_Offset); //New Method

            Kin_Table.each(function(i, row){
                var Kin_Table_Row_Checkbox = $(row).find(":checkbox");
                bChecked = false;
                $(row).addClass(i % 2 == 0 ? Kin_Table_Config.Odd_Style : Kin_Table_Config.Even_Style)
               
			   //鼠标滑过样式
			   //$(row).hover(function(){
                //    $(this).addClass(Kin_Table_Config.Hover_Style);
               // }, function(){
               //     $(this).removeClass(Kin_Table_Config.Hover_Style);
               // });
			   
			   
                //$(row).click(function(){
                    //$(this).toggleClass(Kin_Table_Config.Click_Style);
                   // Kin_Table_Row_Checkbox.each(function(){
                   //     this.checked = $(row).hasClass(Kin_Table_Config.Click_Style);
                   // });
               // });
				
				
                Kin_Table_Row_Checkbox.each(function(){
                    if (this.checked) {
                        bChecked = true;
                        return false;
                    }
                });
				
                if (bChecked) {
                    $(row).addClass(Kin_Table_Config.Click_Style);
                    Kin_Table_Row_Checkbox.each(function(){
                        this.checked = true;
                    });
                }
				
                else {
                    $(row).removeClass(Kin_Table_Config.Click_Style);
                }
            });
        });
    }
$(function() {

    var formElements = function(){
    

        // Bootstrap datepicker
        var feDatepicker = function(){                        
            if($(".datepicker").length > 0){
                $(".datepicker").datepicker({format: 'yyyy-mm-dd'});
            }           
            
        }// END Bootstrap datepicker

        //Bootstrap select
        var feSelect = function(){
			
            if($(".select").length > 0){
                $(".select").selectpicker();

                $(".select").on("change", function(){
                    if($(this).val() == "" || null === $(this).val()){
                        if(!$(this).attr("multiple"))
                            $(this).val("").find("option").removeAttr("selected").prop("selected",false);
                    }else{
                        $(this).find("option[value="+$(this).val()+"]").attr("selected",true);
                    }
                });
            }
            
        }//END Bootstrap select

        // //Bootstrap file input
        var feBsFileInput = function(){ 
            
            if($("input.fileinput").length > 0){
                $("input.fileinput").bootstrapFileInput();                               
            }
            
        }
        //END Bootstrap file input

        //iCheckbox and iRadion - custom elements
        var feiCheckbox = function(){
            if($(".icheckbox").length > 0){
                 $(".icheckbox,.iradio").iCheck({checkboxClass: 'icheckbox_minimal-grey',radioClass: 'iradio_minimal-grey'});
            }
        }
        // END iCheckbox

        return {// Init all form element features
		init: function(){
                    feDatepicker();    
                    feSelect();
                    feBsFileInput();
                    feiCheckbox();
                }
        }
    }();

    var uiElements = function(){

        //Datatables
        var uiDatatable = function(){
            if($(".datatable").length > 0){

                $(".datatable").dataTable({order:[], paging:true, language:{search:'Buscar :'}, info:true});
                $(".datatable").on('page.dt',function () {
                    onresize(100);
                });
            }

            if($(".datatable_simple").length > 0){
                $(".datatable_simple").dataTable({"ordering": false, "info": false, "lengthChange": false,"searching": false});
                $(".datatable_simple").on('page.dt',function () {
                    onresize(100);
                });
            }
        }//END Datatable

         return {
            init: function(){
                uiDatatable();
            }
        }

    }();
    
    formElements.init();
    uiElements.init();


});

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

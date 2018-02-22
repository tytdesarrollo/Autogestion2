    var generalPage = 1;  // pagina en la que se encuentra
    var generalxPage = 10; // cantidad de paginas que tiene
    var generalPageView = new Array(1,2,3,4,5,6,7,8,9,10); //paginas que estan a la vista

    function clickBack(id){
        if(generalPage != 1){            
            var identificador;
            //
            identificador = "#li"+generalPage+""+id;
            $(identificador).removeClass('active');
            //
            generalPage = generalPage - 1;
            if(!pageoutview()){
                changeview(id);
            }
            ejecute(id);
            identificador = "#li"+generalPage+""+id;
            $(identificador).addClass('active');
        }
    }

    function clickNext(id){        
        if(generalPage < generalxPage){                           
            var identificador;            
            //
            identificador = "#li"+generalPage+""+id;
            $(identificador).removeClass('active');                                               
            //
            generalPage = generalPage + 1;    
            if(!pageoutview()){
                changeview(id);
            }
            ejecute(id);
            identificador = "#li"+generalPage+""+id;
            $(identificador).addClass('active');            
        }
    }

    function clickFirst(id){
        var identificador;
        //
        identificador = "#li"+generalPage+""+id;
        $(identificador).removeClass('active');            
        //      
        generalPage = 1;  
        if(!pageoutview()){
            changeview(id);
        }
        ejecute(id);
        identificador = "#li1"+id;
        $(identificador).addClass('active');   
    }

    function clickLast(id){
        var identificador;
        //
        identificador = "#li"+generalPage+""+id;
        $(identificador).removeClass('active');            
        //        
        generalPage = generalxPage;
        if(!pageoutview()){
            changeview(id);
        }
        ejecute(id);
        identificador = "#li"+generalxPage+""+id;
        $(identificador).addClass('active');   
    }

    function clickPage(page, id){
        var identificador;
        //
        identificador = "#li"+generalPage+""+id;
        $(identificador).removeClass('active');            
        //        
        generalPage = page;
        ejecute(id);
        identificador = "#li"+page+""+id;
        $(identificador).addClass('active');   
    }

    function pageoutview(){
        var pagenew = false;
        //        
        for(var i=0 ; i<generalPageView.length ; i++){            
            if(generalPageView[i] == generalPage){                
                pagenew = true;
                break;
            }
        }
        //
        return pagenew;
    }

    function changeview(id){
        //
        var newview = 
            '<li id="liprimero'+id+'"><a href="#" id="primero" onclick="clickFirst('+id+')">Primero</a></li>'+
            '<li id="liback'+id+'"><a href="#" onclick="clickBack('+id+')">&laquo;</a></li>';
        var inicial = generalPage;
        //
        if((inicial + generalPageView.length) > generalxPage){           
            inicial = generalxPage - (generalPageView.length - 1);
        }
        //
        for(var i = 0 ; i<generalPageView.length ; i++){
            generalPageView[i] = inicial;

            if(inicial == generalPage){
                newview = newview +         
                    '<li id="li'+inicial+''+id+'" class="active"><a href="#" id="p'+inicial+''+id+'" onclick="clickPage('+inicial+','+id+')">'+inicial+'</a></li>';
            }else{
                newview = newview +
                    '<li id="li'+inicial+''+id+'"><a href="#" id="p'+inicial+''+id+'" onclick="clickPage('+inicial+','+id+')">'+inicial+'</a></li>';    
            }    

            inicial++;          
        }    

        newview = newview +
            '<li id="linext'+id+'"><a href="#" onclick="clickNext('+id+')">&raquo;</a></li>'+
            '<li id="liultimo'+id+'"><a href="#" id="ultimo'+id+'" onclick="clickLast('+id+')">Ultimo</a></li>';     

        $("#paginationView"+id).html(newview);
    }

    function setGeneralxPage(newValue){
        generalxPage = newValue;        
    }

    function setGeneralValuesDefault(id){
        generalPage = 1;
        generalxPage = 10;
        generalPageView = new Array(1,2,3,4,5,6,7,8,9,10);

        changeview(id);
    }

    function paginationControl(pageSize, id){       
        if(pageSize < 10){
            var inicio = parseInt(pageSize) + 1;
            
            for(var i=inicio ; i<=10 ; i++){
                var elemento = "li"+i+""+id;                
                document.getElementById(elemento).style.display = 'none';
            }
        }
    }

    function ocultarPaginador(id){
       $("#"+id).hide()
    }

    function mostrarPaginador(id){
        $("#"+id).show()   
    }
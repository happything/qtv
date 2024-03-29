$(function(){
   'use strict';
   
   $.widget('blueimpUIX.fileupload', $.blueimpUI.fileupload, {
      
      _renderTemplate : function(func, files){
          return func({
              files          : files,
              formatFileSize : this._formatFileSize,
              options        : this.options
          });
      },
      
      _initTemplates : function(){
          this.options.uploadTemplate = function(o){
              var lis = $();
              $.each(o.files, function(index, file){
                  var li = $("<li class='template-upload'>" + 
                      "<div class='preview'>" +
                        "<span class='fade'></span>"+
                      "</div>"+
                      (file.error ? "<span class='error label important'></span>" : 
                      "<span class='start'><button style='display:none; visibility: hidden;'>Start</button></span>") + "</li>");
                  if(file.error){
                      li.addClass('ui-state-error');
                      //alert(file.error);
                      li.find('.error').text(file.error);
                  }else{
                      li.find('.preview').append("<img src='/img/loader.gif' class='loader' style='display:none'/>");
                  }
                  lis = lis.add(li);
              });
              return lis;
          };
          
          this.options.downloadTemplate = function(o){
              var lis = $();
              $.each(o.files, function(index, file){
                  var li = $("<li class='template-download ui-state-default record'>" +
                      (file.error ? "<div class='preview'></div><span class='error label important'></span>" : 
                      "<div class='preview'>"+
                        "<div class='pop-over'>"+
                            "<div class='media-actions'>"+
                                "<span class='delete'><button class='action delete'>Delete</button></span>"+
                                "<span class='action previewing'><a href='#' rel='gallery'>Preview</a></span>"+
                            "</div>"+
                            "<img src='' alt='' />"+
                        "</div>"+
                      "</div>") + "</li>");
                  if(file.error){
                      li.addClass('ui-state-error');
                      //alert(file.error);
                      li.find('.error').text(file.error);
                  }else{
                      if(file.thumbnail_url){
                          li.find('.preview img').prop('src', file.thumbnail_url);
                          li.attr('id', "recordsArray_"+file.thumbnail_url);
                      }
                      li.find('.previewing a').prop('href', file.url).prop('title', file.name);                      
                      li.find('.delete')
                            .attr('data-type',file.delete_type)
                            .attr('data-url', file.delete_url);
                  }
                  lis = lis.add(li);
              });
              return lis;
          }
      }
   });

  var form = $('form').attr('data-form');

  $("#"+form+"-form").fileupload({
    url      : '/ajax/uploader.php'
  });    
   
   if(form=="ads"){            
       $("#"+form+"-form").fileupload('option',{
           maxFileSize      : 4000000000,
           minFileSize      : 0,
           acceptFileTypes  : /(\.|\/)(zip)$/i,
           previewMaxHeight : 180,
           previewMaxWidth  : 180,
           previewAsCanvas  : false,
           formData         : insert_id,
           paramName        : 'archivos[]',
           singleFileUploads: true,
           start            : function(){
               $('img.loader').css('display', 'inline');
               $('.preview img').css('opacity', '0.8');
           },
           stop             : function(){
               $('.preview img').css('opacity', '1');
           }
       }).bind('fileuploadadd', function(e, data){          
           if(global_data !== null){
               global_data = data;
           }
       }).bind('fileuploaddone', function(e, data){ 
          $.ajax({
            url:"/ajax/ads.php",
            type:"post",
            data:"parent_id="+insert_id,
            cache:false,
            success:function(d){
              if(d == "1") window.location = "/happycms/"+form;    
              else if(d == "0") alert("El archivo subido no es ZIP. Intentalo con otro.");
            }
          });         
          
       });
   } else {
       //Settings
       $("#"+form+"-form").fileupload('option',{
           maxFileSize      : 4000000000,
           minFileSize      : 10000,
           acceptFileTypes  : /(\.|\/)(gif|jpe?g|png)$/i,
           previewMaxHeight : 180,
           previewMaxWidth  : 180,
           previewAsCanvas  : false,
           formData         : insert_id,
           paramName        : 'archivos[]',
           singleFileUploads: false,
           start            : function(){
               $('img.loader').css('display', 'inline');
               $('.preview img').css('opacity', '0.8');
           },
           stop             : function(){
               $('.preview img').css('opacity', '1');
           }
       }).bind('fileuploadadd', function(e, data){
           if(global_data !== null){
               global_data = data;
           }
       }).bind('fileuploaddone', function(e, data){
          if(form == "places_types") window.location = "/happycms/places/places-types";
          else if(form == "nightclubs") window.location = "/happycms/galleries/nightclubs";
          else window.location = "/happycms/"+form;
       });  
   }
   
   /*if(form!="hats"){
       $.getJSON('/ajax/uploader.php', {'seccion' : form, 'insert_id' : insert_id}, function(files){
           var fu = $("#"+form+"-form").data('fileupload'),
               template;
           fu._adjustMaxNumberOfFiles(-files.length);
           template = fu._renderDownload(files).appendTo($('.files'));

           fu._reflow = fu._transition && template.length && template[0].offsetWidth;
           template.addClass('in');
        });   
   }*/
   
});
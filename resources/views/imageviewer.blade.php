<div>
    <div id="risk_image"></div>
    @if(isset($risk_map_path) && $risk_map_path != NULL) 
        <img id ="image_view" src = "{{asset('storage/uploads/'.$risk_map_path)}}"></img>  
    @else
    <span style="color:red; font-weight:bold;">No any image available<span>
    @endif    
    </div>
</div>



  <style>
  /* .risk_image{
      max-height:100%;
      max-width:100%;
  } */
  #image_view{
      margin-left:5%;
      max-width:90%;
      max-height:80%;
  }
  .fancybox-content {
      max-width: 80%;
      max-height:90%;
  }
  </style>
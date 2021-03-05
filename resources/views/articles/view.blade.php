@extends('layouts.article')
@section('content')
@include('articles.partial.nav')
<!--Container-->
<div class="container flex flex-wrap w-full px-2 pt-8 mx-auto mt-10 lg:pt-10">

    @livewire('article.public-view',['article' => $article])

</div>
<!--/container-->
@include('articles.partial.footer')

<script>
    var navMenuDiv = document.getElementById("nav-content");
     var navMenu = document.getElementById("nav-toggle");
     var helpMenu = document.getElementById("menu-toggle");
     
     document.onclick = check;
     
     function check(e){
       var target = (e && e.target) || (event && event.srcElement);
     
      
       //Nav Menu
       if (!checkParent(target, navMenuDiv)) {
         // click NOT on the menu
         if (checkParent(target, navMenu)) {
           // click on the link
           if (navMenuDiv.classList.contains("hidden")) {
             navMenuDiv.classList.remove("hidden");
           } else {navMenuDiv.classList.add("hidden");}
         } else {
           // click both outside link and outside menu, hide menu
           navMenuDiv.classList.add("hidden");
         }
       }
       
     }
     
     function checkParent(t, elm) {
       while(t.parentNode) {
         if( t == elm ) {return true;}
         t = t.parentNode;
       }
       return false;
     }
     
</script>

@endsection
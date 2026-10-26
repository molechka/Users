<ol class="breadcrumb">
  <li><a href="/">Home</a></li>
  <li><a href="/user/list/index.html">Users</a></li>
  <li class="active"><?=$user['name'];?></li>
</ol>
 
<section id="about-us">

        <div class="container">
<h2>Profile</h2>
     <div class="row">

           <div class="col-md-4 center">

<img src="<?=$user['avatar'];?>">
         </div>
         <div class="col-md-8 center">

             <h4><?=$user['name'];?></h4>
             <p>Count messages on forum <?=$user['forum_messages'];?></p>
               </div>
     </div>
<div class="row">
    <widget position="comment">%%widget%%</widget>
</div>


        </div></section>
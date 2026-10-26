	<section class="section ">
				<div class="content-wrapper">

					<div class="container">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2 text-center">

                    <table class="table" style="background:black;">
                  <?
             
                
              if(count($m)>0){
              foreach($m as $mr){
              ?>
                        <tr>
                            <td><?=$mr['name'];?></td>
                             <td><?=$mr['email'];?></td>
                        </tr>
              <?
              }
              }
              ?>
                    </table>
             
<?=$paginator;?>
                </div>
            </div>
        </div>
                                </div>
    </section> <!-- End of CONTACT US SECTION -->

	<!-- FOOTER -->
 




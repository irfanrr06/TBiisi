sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              	  <p class="centered"><a href="index.php"><img src="icon/Jam Gadang.jpeg" class="img-circle" width="140" height="120"></a></p>
              	  <h5 class="centered"><?php echo "Bukittinggi" ?></h5>

                  <li class="sub">
                      <a onclick="init();listTourism();" style="cursor:pointer;background:none"><i class="fa fa-list"></i>List Tourism</a>
                  </li>

                  <li class="sub">
                      <a onclick="" style="cursor:pointer;background:none"><i class="fa fa-thumb-tack"></i>Tourism Around You</a>
                      <ul class="treeview-menu">
                        <!-- <li style="margin-top:10px"><input id="inputradius" type="range" name="inputradius" data-highlight="true" min="1" max="10" value="1"></li>                             
                        <li><a onclick="init();tourism_sekitar_user();" style="cursor:pointer;background:none">Search</a></li> -->
                        <div class=" form-group" style="color: white;" > <!-- <br> -->
                          <!-- <label>Based On Radius</label><br> -->
                          <label for="inputradius" style="font-size: 10pt";>Radius : </label>
                          <label  id="nilai"  style="font-size: 10pt";>0</label> m
                          
                          <input  type="range" onchange="init();tourism_sekitar_user();cekkk();" id="inputradius" 
                                  name="inputradius" data-highlight="true" min="0" max="20" value="0" >
                          <script>
                            function cekkk()
                            {
                              document.getElementById('nilai').innerHTML=document.getElementById('inputradius').value*100
                            }

                            function rad5()
                            {
                              document.getElementById('rad5').innerHTML=document.getElementById('inputradius5').value*100
                            }

                            function rad3()
                            {
                              document.getElementById('rad3').innerHTML=document.getElementById('inputradius3').value*100
                            }

                            function rad4()
                            {
                              document.getElementById('rad4').innerHTML=document.getElementById('inputradius4').value*100
                            }

                            function rad6()
                            {
                              document.getElementById('rad6').innerHTML=document.getElementById('inputradius6').value*100
                            }

                            function rad7()
                            {
                              document.getElementById('rad7').innerHTML=document.getElementById('inputradius7').value*100
                            }
                            function rad8()
                            {
                              document.getElementById('rad8').innerHTML=document.getElementById('inputradius8').value*100
                            }
                            function rad9()
                            {
                              document.getElementById('rad9').innerHTML=document.getElementById('inputradius9').value*100
                            }
                            function rad10()
                            {
                              document.getElementById('rad10').innerHTML=document.getElementById('inputradius10').value*100
                            }

                          </script>
                        </div>
                      </ul>                     
                  </li>

                  <li class="sub-menu">
                    <a href="javascript:;" >
                        <i class="fa fa-search"></i>
                        <span>Search Tourism By</span>
                    </a>
                    <ul class="sub">
                      <li class="sub">
                          <a style="cursor:pointer;background:none"><i class="fa fa-search"></i> By Name</a>
                          <ul class="sub">
                            <li style="margin-top:10px"><input id="input_name" type="text" class="form-control"></li>                             
                            <li><a onclick="init();cari_tourism(1)" style="cursor:pointer;background:none">Search</a></li>
                          </ul>
                      </li>

                      <li class="sub">
                          <a style="cursor:pointer;background:none"><i class="fa fa-search"></i> By Address</a>
                          <ul class="sub">
                            <li style="margin-top:10px"><input id="input_address" type="text" class="form-control"></li>                             
                            <li><a onclick="init();cari_tourism(2)" style="cursor:pointer;background:none">Search</a></li>
                          </ul>
                      </li>

                      <li class="sub">
                          <a style="cursor:pointer;background:none"><i class="fa fa-search"></i> By Type</a>
                          <ul class="sub">
                            <li style="margin-top:10px">
                            <select class="form-control kota text-center" style="width:100%;margin-top:10px" id="select_jenis">
                              <?php                      
                              require_once('../connect.php');    
                              $querysearch="SELECT id, name FROM tourism_type"; 
                              $hasil=pg_query($querysearch);

                                while($baris = pg_fetch_array($hasil)){
                                    $id=$baris['id'];
                                    $name=$baris['name'];
                                    echo "<option value='$id'>$name</option>";
                                }
                              ?>
                            </select>
                            </li>                             
                            <li><a onclick="init();cari_tourism(3)" style="cursor:pointer;background:none">Search</a></li>
                          </ul>
                      </li>

                      <li class="sub">
                          <a style="cursor:pointer;background:none"><i class="fa fa-search"></i> By Facility</a>
                          <ul class="sub">
                            <!-- <li style="margin-top:10px"><input id="input_fasility" type="text" class="form-control"></li> -->   
                            <?php
                              $q = "SELECT * FROM facility_tourism";
                              $r = pg_query($q);
                              while($d=pg_fetch_object($r)){
                                ?>
                                <li style="margin-top:10px;color:white"><input type="checkbox" name="input_fasility[]" value="<?= $d->id; ?>"> <?= $d->name; ?></li>
                                <?php
                              }
                            ?>
                            <li><a onclick="init();cari_tourism(4)" style="cursor:pointer;background:none">Search</a></li>
                          </ul>
                      </li>
                            
                      <li class="sub">
                          <a style="cursor:pointer;background:none"><i class="fa fa-search"></i> By Time and Type</a>
                          <ul class="sub">   
                            <li style="margin-top:10px">
                              <label for="t_type2" style="font-size: 10pt; color:white;">Tourism Type : </label>
                              <select name="t_type2" id="t_type2">
                                <?php
                                  $q = "SELECT * FROM tourism_type";
                                  $r = pg_query($q);
                                  while($d = pg_fetch_object($r)){ ?>
                                    <option value="<?= $d->id; ?>"><?= $d->name; ?></option>
                                <?php
                                  }
                                ?>
                              </select>
                            </li>
                            <li style="margin-top:10px">
                              <label for="open" style="font-size: 10pt; color:white;">Open : </label>
                              <input id="open" type="time" class="form-control">
                            </li>
                            <li style="margin-top:10px">
                              <label for="close" style="font-size: 10pt; color:white;">Close : </label>
                              <input id="close" type="time" class="form-control">
                            </li>
                            <li><a onclick="init();cari_tourism(14)" style="cursor:pointer;background:none">Search</a></li>
                          </ul>
                      </li>
                      <li class="sub">
                          <a style="cursor:pointer;background:none"><i class="fa fa-search"></i> By Ticket</a>
                          <ul class="sub">
                            <li style="margin-top:10px">
                              <label for="t_price2" style="font-size: 10pt; color:white;">Price : </label>
                              <input id="t_price2" type="number" class="form-control">
                            </li>
                            <li><a onclick="init();cari_tourism(15)" style="cursor:pointer;background:none">Search</a></li>
                          </ul>
                      </li>
            
                      <li class="sub">
                          <a style="cursor:pointer;background:none"><i class="fa fa-search"></i> By Ticket & Type</a>
                          <ul class="sub">
                            <li style="margin-top:10px">
                              <label for="t_price4" style="font-size: 10pt; color:white;">Price : </label>
                              <input id="t_price4" type="number" class="form-control">
                            </li>
                            <li style="margin-top:10px">
                              <label for="t_type3" style="font-size: 10pt; color:white;">Tourism Type : </label>
                              <select name="t_type3" id="t_type3">
                                <?php
                                  $q = "SELECT * FROM tourism_type";
                                  $r = pg_query($q);
                                  while($d = pg_fetch_object($r)){ ?>
                                    <option value="<?= $d->id; ?>"><?= $d->name; ?></option>
                                <?php
                                  }
                                ?>
                              </select>
                            </li>
                            <li><a onclick="init();cari_tourism(17)" style="cursor:pointer;background:none">Search</a></li>
                          </ul>
                      </li>
                      
                 
                    </ul>
                  </li>
                  <!-- <li class="sub">
                      <a href="apps.apk" download>
                      <i class="fa fa-download" ></i>Download Android Apps</a>
                  </li> -->
                  <!-- <li class="sub">
                      <a onclick="backToHome();" style="cursor:pointer;background:none"><i class="fa fa-home"></i>Route to First Location</a>
                  </li> -->
                  <li class="sub-menu">
                      <a class="active" href=".././">
                          <i class="fa fa-hand-o-left"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end
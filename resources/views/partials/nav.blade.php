<!-- HEADER -->
<div style="position: relative;">
    <div class="header">
        <div class="menu_all" id="myHeader">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-4 col-md-4 col-lg-4">
                        <div class="logo">
                            <a href="home.html">
                                <div class="logo_img">
                                    <img src="img/logo.png" alt="image">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-8 col-md-8 col-lg-8">
                        <div class="menu_right d-flex">
                            <div class="menu_right_list">
                                <ul class="menu_right_ul d-flex">
                                    <li class="dis_fx_cntr">
                                        <a href="home.html">HOME</a>
                                    </li>
                                    @if (count($cat) > 0)
                                    @foreach ($cat as $nav)
                                    <li>
                                       <a href="/category/{{$nav->categoryName}}/{{$nav->id}}">{{$nav->categoryName}}</a>
                                   </li>
                                    @endforeach
                                @endif
                                   
                                    
                                    <li>
                                        <a href="contact.html">CONTACT</a>
                                    </li>
                                  
                                    <search> </search>
                                  
                                    
                                       @auth
                                       <div class="dropdown">
                                        <button class="dropbtn">  {{$user->fullname}}</button>
                                        <div class="dropdown-content">
                                          <a href="#">1</a>
                                          <a href="#">Link 2</a>
                                          <a href="/logout">Logout</a>
                                        </div>
                                      </div>
                                           @endauth
                                       @guest
                                        <a href="/loginpage">login</a>
                                           
                                       @endguest
                                    
                                   
                                </ul>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- HEADER -->
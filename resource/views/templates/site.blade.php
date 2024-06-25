@php
    use Src\Classes\Storage\Storage;

    $categories = (new \App\Models\Category())->cachedProducts();
    
    $client = auth('site');
    if($client)
        $client = \App\Models\Client::find($client->id);
@endphp

<!DOCTYPE html>
<html lang="{{ config('app.lang') }}">
<head>
    @yield('ld-json')

    <meta http-equiv="Content-Type" content="text/html; charset={{ config('app.charset') }}" />
    <meta name="keywords" content="@yield('keywords', config('app.keywords'))">
    <meta name="description" content="@yield('description', config('app.description'))">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="title" content="{{ config('app.name') }} | @yield('title')" />
    <meta name="author" content="{{ config('app.url') }}" />
    <meta name="geo.region" content="BR-{{ config('app.address.state') }}" />
    <meta name="geo.position" content="{{ config('app.address.latitude') }};{{ config('app.address.longitude') }}" />
    <meta name="ICBM" content="{{ config('app.address.latitude') }};{{ config('app.address.longitude') }}" />

    <meta name="language" content="{{ config('app.lang') }}" />
    <meta name="copyright" content="{{ config('app.name') }}" />
    <meta name="distribution" content="global" />
    <meta name="audience" content="all" />
    <meta name="url" content="@yield('url', config('app.url'))" />
    <meta name="classification" content="{{ config('app.description') }}" />
    <meta name="category" content="{{ config('app.description') }}" />
    <meta name="Page-Topic" content="{{ config('app.name') }} | @yield('title')" />
    <meta name="rating" content="general" />
    <meta name="fone" content="{{ config('app.contact.phone') }}" />
    <meta name="city" content="{{ config('app.address.city') }}" />
    <meta name="country" content="Brasil" />
    <meta property="publisher" content="{{ config('app.name') }}" />

    <meta name="robots" content="index, follow>" />
    <meta name="googlebot" content="index, follow" />
    <meta name="theme-color" content="#163f83">

    <link rel="canonical" href="@yield('url', config('app.url'))" />
    <meta name="geo.placename" content="Brasil" />
    <meta name="geo.region" content="{{ config('app.address.city') }}" />
    <meta name="name" content="{{ config('app.name') }}" />
    <meta name="image" content="@yield('image', public_path('assets/img/favicon.png'))" />

    <meta property="og:url" content="@yield('url', config('app.url'))" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ config('app.name') }} | @yield('title')" />
    <meta property="og:description" content="@yield('description', config('app.description'))" />
    <meta property="og:image" content="@yield('image', public_path('assets/img/favicon.png'))" />
    <meta property="og:image:alt" content="{{ config('app.name') }} | @yield('title')" />
    <meta property="og:image:width" content="@yield('image_width', 48)" /> 
    <meta property="og:image:height" content="@yield('image_height', 48)" /> 
    <meta property="og:site_name" content="{{ config('app.name') }}" /> 
    <meta property="og:locale" content="{{ config('app.lang') }}" />
    {{-- <meta property="og:app_id" content="" /> --}}
    {{-- <meta property="fb:pages" content="" /> --}}
    
    <meta property="article:author" content="{{ config('app.social.facebook') }}" /> 
    <meta property="article:publisher" content="{{ config('app.social.facebook') }}" /> 
    <meta property="twitter:card" content="summary_large_image" /> 
    <meta property="twitter:domain" content="{{ config('app.domain') }}" /> 
    <meta property="twitter:title" content="{{ config('app.name') }} | @yield('title')" /> 
    <meta property="twitter:description" content="@yield('description', config('app.description'))" /> 
    <meta property="twitter:image" content="@yield('image', public_path('assets/img/favicon.png'))" /> 
    <meta property="twitter:url" content="@yield('url', config('app.url'))" />
    <meta name="twitter:card" content="summary" />
    {{-- <meta name="twitter:site" content="@news" /> --}}
    {{-- <meta name="twitter:creator" content="@news" /> --}}
    @yield('metatags')

    <!-- Title -->
    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ public_path('assets/img/favicon.png') }}">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ public_path('assets/dist/site.css?ver=7') }}">
    @yield('styles')
</head>
<body>
    <section class="modal-load">
        <main>
            <div class="load"></div>
            <p>CARREGANDO...</p>
        </main>
    </section>

    @if(!empty(config('floater.image')) && Storage::exists(config('floater.image')) && config('floater.active'))
        @include('includes.site.modais.floater', [
            'title' => 'Aviso',
            'image' => url('storage/app/public/' . config('floater.image')),
            'link' => config('floater.link')
        ])
    @endif

    @php
        $phone = config('app.contact.phone');
        $cell = config('app.contact.cell');
        $email = config('app.contact.email');
        $whatsapp = config('app.social.whatsapp');
        $facebook = config('app.social.facebook');
        $instagram = config('app.social.instagram');
        $linkedin = config('app.social.linkedin');
        $twitter = config('app.social.twitter');
    @endphp

    <!-- HEADER -->
    <header>
        <!-- TOP HEADER -->
        <!-- <div id="top-header">
            <div class="container">
                <ul class="header-links pull-left">
                    @if(!empty($phone))
                    <li><a href="tel:{{ $phone }}" title="Entrar em Contato por Telefone"><i class="fa fa-phone"></i> {{ mask($phone, '(##)####-####') }}</a></li>
                    @endif
                    
                    @if(!empty($email))
                    <li><a href="mailto:{{ $email }}" title="Entrar em Contato por E-Mail"><i class="fa fa-envelope-o"></i> {{ $email }}</a></li>
                    @endif
                    
                    <li><a href="javascript:void(0)" title="Visite nossa loja nesse endereço"><i class="fa fa-map-marker"></i>{{ config('app.address.city') }} - {{ config('app.address.state') }}</a></li>
                </ul>
                <ul class="header-links pull-right">
                    @if(!auth('site'))
                    <li><a href="{{ route('site.login') }}" title="Fazer Login em Minha Conta">Login</a></li>
                    <li><a href="{{ route('site.account.pj.create') }}" title="Criar Minha Conta">Criar Conta</a></li>
                    @else
                    <li><a href="{{ route('site.myaccount') }}" title="Minha Conta"><i class="fa fa-user-circle"></i> Minha Conta</a></li>
                    @endif
                </ul>
            </div>
        </div> -->
        <!-- /TOP HEADER -->

        <!-- MAIN HEADER -->
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="{{ url() }}" class="logo" title="{{ config('app.name') }}">
                                <img src="{{ public_path('assets/img/logo.png') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <!-- <div class="col-md-8">
                        <div class="header-search">
                            <form action="{{ route('site.products') }}" method="POST">
                                <select class="input-select select-url">
                                    <option value="0" data-url="{{ route('site.products') }}">Todos</option>
                                    @foreach($categories as $category)
                                        @if(count($category->subcategories))
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}" data-url="{{ route('site.products.category.subcategory', ['category' => $category->slug, 'subcategory' => $subcategory->slug]) }}">{{ $subcategory->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                                <input type="text" class="input" placeholder="Buscar" name="search" value="{{ $search ?? null }}">
                                <button class="search-btn"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div> -->
                    <!-- /SEARCH BAR -->
                    <div class="col-md-9">
                        <ul class="header-links pull-right">
                                <li class="icon"><i class="fa fa-search search-btn"></i></li>
                                
                            
                                <li class="search-list-item"><form action="{{ route('site.products') }}" method="POST"><input type="text" class="input" placeholder="Buscar" name="search" value="{{ $search ?? null }}">                            </form></li>

                            @if(!auth('site'))
                            <li><a href="{{ route('site.login') }}" title="Fazer Login em Minha Conta">Login</a></li>
                            <li><a href="{{ route('site.account.pj.create') }}" title="Criar Minha Conta">Criar Conta</a></li>
                            @else
                            <li><a href="{{ route('site.myaccount') }}" title="Minha Conta">Minha Conta</a></li>
                            <li><a href="{{ route('site.myaccount.logout') }}" title="Sair">Sair</a></li>
                            @endif
                        </ul>
                    </div>

                    <!-- ACCOUNT -->
                    <div class="col-md-1 clearfix">
                        <div class="header-ctn">
                            <!-- Menu Toogle -->
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span>Menu</span>
                                </a>
                            </div>
                            <!-- /Menu Toogle -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->

        
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation navbar navbar-expand-lg">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav" style="display: flex;flex-direction: column;justify-content: start;">
                
                <i class="fa fa-close" id="fechar-menu-mobile" style="display: none;font-size: 2rem;"></i>
                <!-- NAV -->
                <ul class="collapse navbar-collapse main-nav nav navbar-nav">
                    <!-- <li class="active"><a href="{{ route('site') }}" title="Página Inicial">Início</a></li> -->
                    <!-- <li><a href="{{ route('site.products') }}" title="Página de Produtos">Produtos</a></li>
                    <li><a href="{{ route('site.notices') }}" title="Página do Blog">Blog</a></li> -->
                    @foreach($categories as $category)
                        @if(count($category->subcategories))
                            <li class="nav-item backdrop dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" title="Categoria">
                                    <img src="/storage/app/public/{{ $category->image }}" style="width: 32px;">
                                    {{ $category->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <div class="dropdown-container">
                                        @foreach($category->subcategories as $subcategory)
                                            <a href="{{ route('site.products.category.subcategory', ['category' => $category->slug, 'subcategory' => $subcategory->slug]) }}" class="dropdown-item" href="#">{{ $subcategory->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>
    <!-- /NAVIGATION -->

    @php 
        $routeComplete = '';
        $routes = explode('/', route());
    @endphp

    @if(!empty($routes) && !empty($routes[0]))
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        @empty(route())
                        <li class="active">inicio</li>
                        @else
                        <li><a href="{{ url() }}">inicio</a></li>
                        @foreach($routes as $route)
                            @php $routeComplete .= $route . '/' @endphp

                            @if(!$loop->last)
                            <li><a href="{{ url($routeComplete) }}">{{ $route }}</a></li>
                            @else
                            @php $routeComplete = $route @endphp
                            @endif
                        @endforeach
                        <li class="active">{{ trim($routeComplete, '/') }}</li>
                        @endempty
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->
    @endif

    <!-- SECTION -->
    <div class="section">
        <!-- row -->
        <div class="row">
            @yield('container')
        </div>
        <!-- /row -->
    </div>
    <!-- /SECTION -->
    
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <div class="logo">
                    <a href="https://www.techscan.com.br"><img src="{{ public_path('assets/img/logo_white.png') }}"></a>
                </div>
                <!-- <p class="by"><a href="http://www.thunderbold.com.br" target="blank">Desenvolvido por Thunderbold</a></p> -->
            </div>
            <div class="col-lg-3 col-lg-push-1 col-md-3 col-md-push-1 col-sm-4 col-xs-12">
                <div class="footer">
                    <h3 class="footer-title">Contato</h3>
                    <ul class="footer-links">
                        <li><i class="fa fa-map-marker"></i> {{ config('app.address.city') }} - {{ config('app.address.state') }}</li>
                        
                        @if(!empty($phone))
                        <li><a href="tel:{{ $phone }}" title="Entrar em Contato por Telefone"><i class="fa fa-phone"></i> {{ mask($phone, '(##)####-####') }}</a></li>
                        @endif
                        
                        @if(!empty($cell))
                        <li><a href="tel:{{ $cell }}" title="Entrar em Contato por Celular"><i class="fa fa-phone"></i> {{ mask($cell, '(##)#####-####') }}</a></li>
                        @endif
                        
                        @if(!empty($whatsapp))
                        <li><a href="https://wa.me/55{{ $whatsapp }}?text={{ urlencode('Olá, gostária de tirar algumas dúvida!') }}" title="Entrar em Contato por Whatsapp" target="_blank"><i class="fa fa-whatsapp"></i> {{ mask($whatsapp, '(##)#####-####') }}</a></li>
                        @endif

                        @if(!empty($email))
                        <li><a href="mailto:{{ $email }}" title="Entrar em Contato por E-Mail"><i class="fa fa-envelope-o"></i> {{ $email }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-lg-push-2 col-md-3 col-md-push-2 col-sm-4 col-xs-12">
                <div class="footer">
                    <h3 class="footer-title">Informações</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('site') }}" title="Página Inicial">Início</a></li>
                        <li><a href="{{ route('site.products') }}" title="Página de Produtos">Produtos</a></li>
                        <!-- <li><a href="{{ route('site.notices') }}" title="Página do Blog">Blog</a></li> -->
                        <li><a href="{{ route('site.privacy_policy') }}" title="Nossa Política de Privacidade" target="_blank">Política de Privacidade</a></li>
                        <li><a href="{{ route('site.terms_conditions') }}" title="Nosso Termos e Condições" target="_blank">Termos & Condições</a></li>
                        <!-- <li><a href="{{ route('site.return_policy') }}" title="Nossa Política de Devolução" target="_blank">Política de Devolução</a></li> -->
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-lg-push-3 col-md-3 col-md-push-3 col-sm-4 col-xs-12">
                <div class="footer">
                    <h3 class="footer-title">Serviços</h3>
                    <ul class="footer-links">
                        <!-- <li><a href="{{ route('site.cart') }}" title="Carrinho de Compras">Carrinho</a></li> -->
                        @if(!auth('site'))
                        <li><a href="{{ route('site.login') }}" title="Fazer Login em Minha Conta">Login</a></li>
                        <li><a href="{{ route('site.account.pj.create') }}" title="Criar Minha Conta">Criar Conta</a></li>
                        @else
                        <li><a href="{{ route('site.myaccount') }}" title="Minha Conta">Minha Conta</a></li>
                        <li><a href="{{ route('site.myaccount.favorites') }}" title="Seus Produtos Favoritos">Favoritos</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- bottom footer -->
    <div id="bottom-footer" class="section">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <span class="copyright">{{ config('app.name') }} &copy; {{ date('Y') }} Todos os direitos reservados</span>
                </div>
            </div>
                <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bottom footer -->
</footer>

    @if(config('lgpd.active') && (!isset($_COOKIE['cookieaccept']) || !$_COOKIE['cookieaccept']))
    @include('includes.site.lgpd')
    @endif

    <!-- ##### All Javascript Script ##### -->
    <script type="text/javascript" src="{{ public_path('assets/dist/site.js?ver=6') }}"></script>
    @yield('scripts')
</body>
</html>

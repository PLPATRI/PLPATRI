<!DOCTYPE html>

<html lang="pt-BR">
<!-- Mirrored from etikto-admin-dashboard.multipurposethemes.com/bs5/main-horizontal/auth_login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Sep 2024 12:48:16 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://etikto-admin-dashboard.multipurposethemes.com/bs5/images/favicon.ico">

    <title>Login </title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="public/css/horizontal-menu.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/skin_color.css">

    <style type="text/css">
        .jqstooltip {
            position: absolute;
            left: 0px;
            top: 0px;
            visibility: hidden;
            background: rgb(0, 0, 0) transparent;
            background-color: rgba(0, 0, 0, 0.6);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
            color: white;
            font: 10px arial, san serif;
            text-align: left;
            white-space: nowrap;
            padding: 5px;
            border: 1px solid white;
            box-sizing: content-box;
            z-index: 10000;
        }

        .jqsfield {
            color: white;
            font: 10px arial, san serif;
            text-align: left;
        }
    </style>
</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url('imgs/backgrounds/login.jpg')">

    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">

            <div class="col-12">
                <div class="row justify-content-center g-0">
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="bg-white rounded10 shadow-lg">
                            <div class="content-top-agile p-20 pb-0">
                                <img class="img-fluid" src="imgs/logo.jpg" style="width: 100px">
                                <h2 class="text-primary">Login</h2>
                                <p class="mb-0">Entre com seu acesso</p>
                            </div>
                            <div class="p-40">
                                <form action="{{ route('login.post') }}" method="post">
                                    @method('POST')
                                    @csrf
                                    <div class="form-group">
                                        <select class="form-select" name="tipo_login" id="tipo_login"
                                            onchange="updateInputName()">
                                            <option selected>Tipo do Login</option>
                                            <option value="admin">Admin</option>
                                            <option value="vendedor">Vendedor</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"></span>
                                            <input type="text" id="user_input" name="email"
                                                class="form-control ps-15 bg-transparent"
                                                placeholder="E-mail Ou Usuario" style="display: block;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"></span>
                                            <input type="password" name="senha"
                                                class="form-control ps-15 bg-transparent" placeholder="Senha">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary mt-10">Acessar</button>
                                        </div>
                                    </div>
                                </form>

                                <script>
                                    function updateInputName() {
                                        const tipoLogin = document.getElementById('tipo_login').value;
                                        const userInput = document.getElementById('user_input');

                                        if (tipoLogin === 'admin') {
                                            userInput.name = 'email';
                                            userInput.placeholder = 'E-mail';
                                        } else if (tipoLogin === 'vendedor') {
                                            userInput.name = 'usuario';
                                            userInput.placeholder = 'Usuário';
                                        } else {
                                            userInput.placeholder = '';
                                        }
                                    }
                                </script>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Vendor JS -->
    <script src="js/vendors.min.js"></script>
    <script src="js/pages/chat-popup.js"></script>
    <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/icons/feather-icons/feather.min.js">
    </script>

    <!-- Code injected by live-server -->
    <script>
        // <![CDATA[  <-- For SVG support
        if ('WebSocket' in window) {
            (function() {
                function refreshCSS() {
                    var sheets = [].slice.call(document.getElementsByTagName("link"));
                    var head = document.getElementsByTagName("head")[0];
                    for (var i = 0; i < sheets.length; ++i) {
                        var elem = sheets[i];
                        var parent = elem.parentElement || head;
                        parent.removeChild(elem);
                        var rel = elem.rel;
                        if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() ==
                            "stylesheet") {
                            var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
                            elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date()
                                .valueOf());
                        }
                        parent.appendChild(elem);
                    }
                }
                var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
                var address = protocol + window.location.host + window.location.pathname + '/ws';
                var socket = new WebSocket(address);
                socket.onmessage = function(msg) {
                    if (msg.data == 'reload') window.location.reload();
                    else if (msg.data == 'refreshcss') refreshCSS();
                };
                if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
                    console.log('Live reload enabled.');
                    sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
                }
            })();
        } else {
            console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
        }
        // ]]>
    </script>




</body>

</html>

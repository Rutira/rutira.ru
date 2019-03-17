<!DOCTYPE html>
<html>
    <head>
        <title>
            rutira.ru Авторизация Facebook
        </title>
      
        <meta name="keywords" content="Autorisation">
        <meta name="description" content="This is a sample page to illustrate how to write HTML code for a web page.">
		
		<script type="text/javascript">
            function message() //Проверка JS alert
            {
                alert("This is a Javascript alert box. It's working !!!")
            }

        </script>
    </head>
    <body>
        <h1>Авторизация Facebook</h1>
        <p>Тест авторизации Facebook</p>
        <button onclick="message()">Проверка JS alert</button>
		<!-- <button onclick="fncLogin_Facebook()">Авторизация Facebook</button>  // -->

			  <script type="text/javascript"> //Авторизация Facebook 
			  window.fbAsyncInit = function() {
				FB.init({
				  appId      : '562894597564139',
				  cookie     : true,
				  xfbml      : true,
				  version    : 'v3.2'
				});
				FB.AppEvents.logPageView();   
			  };
			  (function(d, s, id){
				 var js, fjs = d.getElementsByTagName(s)[0];
				 if (d.getElementById(id)) {return;}
				 js = d.createElement(s); js.id = id;
				 js.src = "https://connect.facebook.net/en_US/sdk.js";
				 fjs.parentNode.insertBefore(js, fjs);
			   }(document, 'script', 'facebook-jssdk'));
			</script>
<!-- 	Объект response, переданный обратному вызову, содержит несколько полей:
{
    status: 'connected',
    authResponse: {
        accessToken: '...',
        expiresIn:'...',
        signedRequest:'...',
        userID:'...'
    }
}
status сообщает о состоянии входа человека в приложение. Состояния:
    connected — человек выполнил вход на Facebook и в ваше приложение.
    not_authorized — человек выполнил вход на Facebook, но не вошел в приложение.
    unknown — человек не вошел на Facebook
authResponse будет добавлен, если статус — connected и состоит из следующих элементов:
    accessToken — содержит маркер доступа для пользователя приложения.
    expiresIn — указывает UNIX-время, когда срок действия маркера истечет и его нужно будет обновить.
    signedRequest — параметр подписи, содержащий сведения о пользователе приложения.
    userID — указывает ID пользователя приложения.
-->

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v3.2&appId=562894597564139&autoLogAppEvents=1"></script>
<div class="fb-login-button" data-width="200" data-size="medium" data-button-type="login_with" data-auto-logout-link="true" data-use-continue-as="false"></div>
		
<!-- Атрибут onlogin на кнопке для настройки обратного вызова JavaScript, который проверяет статус входа, чтобы узнать, выполнен ли вход: -->
<p> Арибут onlogin </p>
<script>
<fb:login-button 
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>
</script>

<p> Обратный вызов </p>
<script>
<!--Так выглядит обратный вызов. Он обращается к FB.getLoginStatus(), чтобы получить новейшие данные о состоянии входа. 
(statusChangeCallback() — это функция, которая обрабатывает отклик.) -->
function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}
</script>

<p> Спиннер загрузки </p>
	<script> // спиннер загрузки
	var finished_rendering = function() {
	  console.log("finished rendering plugins");
	  var spinner = document.getElementById("spinner");
	  spinner.removeAttribute("style");
	  spinner.removeChild(spinner.childNodes[0]);
	}
	FB.Event.subscribe('xfbml.render', finished_rendering);
	</script>

	<div id="spinner"
		style="
			background: #4267b2;
			border-radius: 5px;
			color: white;
			height: 40px;
			text-align: center;
			width: 250px;">
		Loading
		<div
		class="fb-login-button"
		data-max-rows="1"
		data-size="large"
		data-button-type="continue_with"
		data-use-continue-as="true"
		></div>
	</div>

	</body>
</html>
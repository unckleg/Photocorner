<hr>
<footer>
   <p class="pull-right"><a href="#">Vrati se na vrh</a></p>
   <p>&copy; {{ date("Y") }} {{ siteSettings('siteName') }}&nbsp;&middot;&nbsp;
      <a href="{{ route('blogs') }}">{{ t('Blogs') }}</a>&nbsp;&middot;&nbsp;
      <a href="{{ route('privacy') }}">{{ t('Privacy Policy') }}</a>&nbsp;&middot;&nbsp;
      <a href="{{ route('tos') }}">{{ t('Terms') }}</a>&nbsp;&middot;&nbsp;
      <a href="{{ route('faq') }}">{{ t('FAQ') }}</a>&nbsp;&middot;&nbsp;
      <a href="{{ route('about') }}">{{ t('About Us') }}</a>
      @include('master/language')
   </p>
</footer>
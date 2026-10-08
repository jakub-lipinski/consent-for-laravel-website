<a href="{{ route('home') }}#principles">Features</a>
<a href="{{ route('home') }}#setup">Integrations</a>
<a href="{{ route('home') }}#preview">Live demo</a>
<a href="{{ route('docs.index') }}" @if(request()->routeIs('docs.*')) aria-current="page" @endif>Documentation</a>

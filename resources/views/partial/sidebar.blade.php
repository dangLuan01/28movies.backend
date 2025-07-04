 <!-- sidebar nav -->
 <ul class="sidebar__nav">
    <li class="sidebar__nav-item">
        <a href="{{route('dashboard')}}" class="sidebar__nav-link {{ Route::is('dashboard') ? 'sidebar__nav-link--active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M20,8h0L14,2.74a3,3,0,0,0-4,0L4,8a3,3,0,0,0-1,2.26V19a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3V10.25A3,3,0,0,0,20,8ZM14,20H10V15a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H16V15a3,3,0,0,0-3-3H11a3,3,0,0,0-3,3v5H6a1,1,0,0,1-1-1V10.25a1,1,0,0,1,.34-.75l6-5.25a1,1,0,0,1,1.32,0l6,5.25a1,1,0,0,1,.34.75Z" />
            </svg>
            <span>Dashboard</span></a>
    </li>
    <!-- collapse -->
    <li class="sidebar__nav-item">
        <a class="sidebar__nav-link {{ Route::is('movie.product.index') || Route::is('movie.product.create') || Route::is('movie.product.crawler') || Route::is('movie.episode.crawler') ? 'sidebar__nav-link--active' : '' }}" data-toggle="collapse" href="#collapseMovie" role="button" aria-expanded="false" aria-controls="collapseMenu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M19,5.5H12.72l-.32-1a3,3,0,0,0-2.84-2H5a3,3,0,0,0-3,3v13a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V8.5A3,3,0,0,0,19,5.5Zm1,13a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5.5a1,1,0,0,1,1-1H9.56a1,1,0,0,1,.95.68l.54,1.64A1,1,0,0,0,12,7.5h7a1,1,0,0,1,1,1Z" />
            </svg>
            <span>Movies</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M17,9.17a1,1,0,0,0-1.41,0L12,12.71,8.46,9.17a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42l4.24,4.24a1,1,0,0,0,1.42,0L17,10.59A1,1,0,0,0,17,9.17Z" />
            </svg>
        </a>
        <ul class="collapse sidebar__menu {{ Route::is('movie.product.index') || Route::is('movie.product.create') || Route::is('movie.product.crawler') || Route::is('movie.episode.crawler') ? 'show' : '' }}" id="collapseMovie">
            <li><a href="{{route('movie.product.index')}}" class="{{ Route::is('movie.product.index') || Route::is('movie.product.edit') ? 'active' : '' }}">List</a></li>
            <li><a href="{{route('movie.product.create')}}" class="{{ Route::is('movie.product.create') ? 'active' : '' }}">Add item</a></li>
            <li><a href="{{route('movie.episode.create')}}" class="{{ Route::is('movie.episode.create') ? 'active' : '' }}">Create Episode</a></li>
            <li><a href="{{route('movie.product.crawler')}}" class="{{ Route::is('movie.product.crawler') ? 'active' : '' }}">Crawler</a></li>
            <li><a href="{{route('movie.episode.crawler')}}" class="{{ Route::is('movie.episode.crawler') ? 'active' : '' }}">Crawler Episode</a></li>
        </ul>
    </li>
    <li class="sidebar__nav-item">
        <a class="sidebar__nav-link {{ Route::is('movie.genre.index') ? 'sidebar__nav-link--active' : '' }}" data-toggle="collapse" href="#collapseGenre" role="button" aria-expanded="false" aria-controls="collapseMenu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M19,5.5H12.72l-.32-1a3,3,0,0,0-2.84-2H5a3,3,0,0,0-3,3v13a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V8.5A3,3,0,0,0,19,5.5Zm1,13a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5.5a1,1,0,0,1,1-1H9.56a1,1,0,0,1,.95.68l.54,1.64A1,1,0,0,0,12,7.5h7a1,1,0,0,1,1,1Z" />
            </svg>
            <span>Genre</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M17,9.17a1,1,0,0,0-1.41,0L12,12.71,8.46,9.17a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42l4.24,4.24a1,1,0,0,0,1.42,0L17,10.59A1,1,0,0,0,17,9.17Z" />
            </svg>
        </a>
        <ul class="collapse sidebar__menu {{ Route::is('movie.genre.index') || Route::is('movie.genre.edit') ? 'show' : '' }}" id="collapseGenre">
            <li><a href="{{route('movie.genre.index')}}" class="{{ Route::is('movie.genre.index') || Route::is('movie.genre.edit') ? 'active' : '' }}">List</a></li>
        </ul>
    </li>
    <li class="sidebar__nav-item">
        <a class="sidebar__nav-link {{ Route::is('movie.collection.index') ? 'sidebar__nav-link--active' : '' }}" data-toggle="collapse" href="#collapseCollection" role="button" aria-expanded="false" aria-controls="collapseMenu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M19,5.5H12.72l-.32-1a3,3,0,0,0-2.84-2H5a3,3,0,0,0-3,3v13a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V8.5A3,3,0,0,0,19,5.5Zm1,13a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5.5a1,1,0,0,1,1-1H9.56a1,1,0,0,1,.95.68l.54,1.64A1,1,0,0,0,12,7.5h7a1,1,0,0,1,1,1Z" />
            </svg>
            <span>Collection</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M17,9.17a1,1,0,0,0-1.41,0L12,12.71,8.46,9.17a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42l4.24,4.24a1,1,0,0,0,1.42,0L17,10.59A1,1,0,0,0,17,9.17Z" />
            </svg>
        </a>
        <ul class="collapse sidebar__menu {{ Route::is('movie.collection.index') || Route::is('movie.collection.edit') ? 'show' : '' }}" id="collapseCollection">
            <li><a href="{{route('movie.collection.index')}}" class="{{ Route::is('movie.collection.index') || Route::is('movie.collection.create') || Route::is('movie.collection.edit') ? 'active' : '' }}">List</a></li>
        </ul>
    </li>
    <li class="sidebar__nav-item">
        <a class="sidebar__nav-link {{ Route::is('movie.theme.index') || Route::is('movie.theme.edit') || Route::is('movie.theme.create') ? 'sidebar__nav-link--active' : '' }}" data-toggle="collapse" href="#collapseTheme" role="button" aria-expanded="false" aria-controls="collapseMenu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M19,5.5H12.72l-.32-1a3,3,0,0,0-2.84-2H5a3,3,0,0,0-3,3v13a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V8.5A3,3,0,0,0,19,5.5Zm1,13a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5.5a1,1,0,0,1,1-1H9.56a1,1,0,0,1,.95.68l.54,1.64A1,1,0,0,0,12,7.5h7a1,1,0,0,1,1,1Z" />
            </svg>
            <span>Theme</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M17,9.17a1,1,0,0,0-1.41,0L12,12.71,8.46,9.17a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42l4.24,4.24a1,1,0,0,0,1.42,0L17,10.59A1,1,0,0,0,17,9.17Z" />
            </svg>
        </a>
        <ul class="collapse sidebar__menu {{ Route::is('movie.theme.index') || Route::is('movie.theme.edit') || Route::is('movie.theme.create') ? 'show' : '' }}" id="collapseTheme">
            <li><a href="{{route('movie.theme.index')}}" class="{{ Route::is('movie.theme.index') || Route::is('movie.theme.create') || Route::is('movie.theme.edit') ? 'active' : '' }}">List</a></li>
        </ul>
    </li>
    <!-- end collapse -->
    <li class="sidebar__nav-item">
        <a href="users.html" class="sidebar__nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12.3,12.22A4.92,4.92,0,0,0,14,8.5a5,5,0,0,0-10,0,4.92,4.92,0,0,0,1.7,3.72A8,8,0,0,0,1,19.5a1,1,0,0,0,2,0,6,6,0,0,1,12,0,1,1,0,0,0,2,0A8,8,0,0,0,12.3,12.22ZM9,11.5a3,3,0,1,1,3-3A3,3,0,0,1,9,11.5Zm9.74.32A5,5,0,0,0,15,3.5a1,1,0,0,0,0,2,3,3,0,0,1,3,3,3,3,0,0,1-1.5,2.59,1,1,0,0,0-.5.84,1,1,0,0,0,.45.86l.39.26.13.07a7,7,0,0,1,4,6.38,1,1,0,0,0,2,0A9,9,0,0,0,18.74,11.82Z" />
            </svg>
            <span>Users</span></a>
    </li>
    <li class="sidebar__nav-item">
        <a href="comments.html" class="sidebar__nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M8,11a1,1,0,1,0,1,1A1,1,0,0,0,8,11Zm4,0a1,1,0,1,0,1,1A1,1,0,0,0,12,11Zm4,0a1,1,0,1,0,1,1A1,1,0,0,0,16,11ZM12,2A10,10,0,0,0,2,12a9.89,9.89,0,0,0,2.26,6.33l-2,2a1,1,0,0,0-.21,1.09A1,1,0,0,0,3,22h9A10,10,0,0,0,12,2Zm0,18H5.41l.93-.93a1,1,0,0,0,.3-.71,1,1,0,0,0-.3-.7A8,8,0,1,1,12,20Z" />
            </svg>
            <span>Comments</span>
        </a>
    </li>
    <li class="sidebar__nav-item">
        <a href="reviews.html" class="sidebar__nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
            </svg>
            <span>Reviews</span></a>
    </li>
    <li class="sidebar__nav-item">
        <a href="../main/index.html" class="sidebar__nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M17,11H9.41l3.3-3.29a1,1,0,1,0-1.42-1.42l-5,5a1,1,0,0,0-.21.33,1,1,0,0,0,0,.76,1,1,0,0,0,.21.33l5,5a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L9.41,13H17a1,1,0,0,0,0-2Z" />
            </svg>
            <span>Back to FlixTV</span></a>
    </li>
</ul>
<!-- end sidebar nav -->

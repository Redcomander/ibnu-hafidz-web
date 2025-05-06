@extends('layouts.main-navigation')

@section('head')
    <!-- Google Sign-In API -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-signin-client_id" content="{{ config('services.google.client_id') }}">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
@endsection

@section('content')
    <!-- Reading Progress Bar with Gradient -->
    <div class="reading-progress-container">
        <div class="reading-progress-bar" id="readingProgressBar"></div>
    </div>

    <!-- Breadcrumbs with Enhanced Styling -->
    <div class="container mx-auto px-4 py-4">
        <nav class="breadcrumbs text-sm" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center space-x-1">
                <li><a href="{{ route('home') }}" class="hover:text-green-600 transition flex items-center">
                        <i class="fas fa-home mr-1"></i> Home</a>
                </li>
                <li><span class="text-gray-400 mx-1">/</span></li>
                <li><a href="{{ route('all-articles') }}" class="hover:text-green-600 transition">Articles</a></li>
                <li><span class="text-gray-400 mx-1">/</span></li>
                @if($article->category)
                    <li><a href="{{ route('categories.show', $article->category->slug) }}"
                            class="hover:text-green-600 transition">{{ $article->category->name }}</a></li>
                    <li><span class="text-gray-400 mx-1">/</span></li>
                @endif
                <li aria-current="page" class="text-gray-600 truncate max-w-xs">{{ $article->title }}</li>
            </ol>
        </nav>
    </div>

    <!-- Article Header -->
    <header class="article-header relative">
        <div class="article-header-bg"
            style="background-image: url('{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : asset('images/default-article-bg.jpg') }}')">
        </div>
        <div class="article-header-overlay"></div>
        <div class="container mx-auto px-4 py-24 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up" data-aos-duration="800">
                @if($article->category)
                    <a href="{{ route('categories.show', $article->category->slug) }}" class="category-badge">
                        <i class="fas fa-folder mr-2"></i>{{ $article->category->name }}
                    </a>
                @endif
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mt-6 mb-8 leading-tight">
                    {{ $article->title }}
                </h1>

                <div class="flex items-center justify-center space-x-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-300 ring-4 ring-white/20">
                            <img src="{{ $article->author && $article->author->foto_guru ? asset('storage/' . $article->author->foto_guru) : asset('images/default-avatar.jpg') }}"
                                alt="{{ $article->author ? $article->author->name : 'Author' }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="ml-3 text-sm">
                            <span
                                class="block font-medium text-base">{{ $article->author ? $article->author->name : 'Unknown Author' }}</span>
                            <span
                                class="text-white/70">{{ $article->author && $article->author->role ? $article->author->role : 'Writer' }}</span>
                        </div>
                    </div>
                    <div class="h-10 w-px bg-white/20"></div>
                    <div class="flex flex-col items-center">
                        <span class="text-sm opacity-80 flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Draft' }}
                        </span>
                    </div>
                    <div class="h-10 w-px bg-white/20"></div>
                    <div class="flex flex-col items-center">
                        <span class="text-sm opacity-80 flex items-center">
                            <i class="far fa-clock mr-2"></i>
                            {{ $article->reading_time ?? '5 min read' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative Wave Divider -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="transform: translateY(1px);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="w-full h-auto">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </header>

    <!-- Article Content -->
    <main class="article-content py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-12 gap-8">
                <!-- Main Content -->
                <div class="col-span-12 lg:col-span-8 article-body" data-aos="fade-up">
                    <div class="prose prose-lg max-w-none">
                        {!! $article->body !!}
                    </div>

                    <!-- Tags with Enhanced Design -->
                    @if(isset($article->tags) && count($article->tags) > 0)
                        <div class="mt-12 pt-6 border-t border-gray-100">
                            <h4 class="text-lg font-semibold mb-3 flex items-center">
                                <i class="fas fa-tags mr-2 text-gray-500"></i> Tags
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($article->tags as $tag)
                                    <a href="{{ route('tags.show', $tag->slug) }}" class="tag-pill">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Redesigned Author Bio Section -->
                    <div class="mt-12 pt-6">
                        <div class="author-card">
                            <div class="author-card-content">
                                <div class="author-avatar-container">
                                    <div class="author-avatar">
                                        <img src="{{ $article->author && $article->author->foto_guru ? asset('storage/' . $article->author->foto_guru) : asset('images/default-avatar.jpg') }}"
                                            alt="{{ $article->author ? $article->author->name : 'Author' }}">
                                    </div>
                                </div>
                                <h3 class="author-name">
                                    {{ $article->author ? $article->author->name : 'Unknown Author' }}
                                </h3>
                                <p class="author-role">
                                    {{ $article->author && $article->author->role ? $article->author->role : 'Writer and contributor' }}
                                </p>
                                <div class="author-bio">
                                    <p>{{ $article->author && $article->author->bio
        ? $article->author->bio
        : 'Writer and contributor at our platform. Passionate about sharing knowledge and insights with our readers.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Simple Social Share (Mobile) -->
                    <div class="mt-8 lg:hidden">
                        <div class="mobile-share-container">
                            <h4 class="mobile-share-title">Share this article</h4>
                            <div class="mobile-share-buttons">
                                <button class="mobile-share-button facebook" aria-label="Share on Facebook"
                                    onclick="shareArticle('facebook')">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button class="mobile-share-button twitter" aria-label="Share on Twitter"
                                    onclick="shareArticle('twitter')">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button class="mobile-share-button linkedin" aria-label="Share on LinkedIn"
                                    onclick="shareArticle('linkedin')">
                                    <i class="fab fa-linkedin-in"></i>
                                </button>
                                <button class="mobile-share-button whatsapp" aria-label="Share on WhatsApp"
                                    onclick="shareArticle('whatsapp')">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                                <button class="mobile-share-button copy-link" aria-label="Copy link"
                                    onclick="copyArticleLink()">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Sidebar -->
                <aside class="col-span-12 lg:col-span-4" data-aos="fade-left">
                    <!-- Simple Social Share (Desktop) -->
                    <div class="sidebar-widget mb-8">
                        <h3 class="sidebar-widget-title">
                            <i class="fas fa-share-alt text-green-600 mr-2"></i>Share
                        </h3>
                        <div class="flex justify-center gap-3 py-4">
                            <button class="sidebar-share-button facebook" aria-label="Share on Facebook"
                                onclick="shareArticle('facebook')">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="sidebar-share-button twitter" aria-label="Share on Twitter"
                                onclick="shareArticle('twitter')">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="sidebar-share-button linkedin" aria-label="Share on LinkedIn"
                                onclick="shareArticle('linkedin')">
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                            <button class="sidebar-share-button whatsapp" aria-label="Share on WhatsApp"
                                onclick="shareArticle('whatsapp')">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button class="sidebar-share-button copy-link" aria-label="Copy link"
                                onclick="copyArticleLink()">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Related Articles with Enhanced Design -->
                    <div class="sidebar-widget">
                        <h3 class="sidebar-widget-title">
                            <i class="fas fa-newspaper text-green-600 mr-2"></i>Related Articles
                        </h3>
                        <div class="space-y-4">
                            @if(isset($relatedArticles) && count($relatedArticles) > 0)
                                @foreach($relatedArticles as $relatedArticle)
                                    <a href="{{ route('articles.show', ['category' => $relatedArticle->category->slug, 'article' => $relatedArticle->slug]) }}"
                                        class="related-article-card">
                                        <div class="related-article-image">
                                            <img src="{{ $relatedArticle->thumbnail ? asset('storage/' . $relatedArticle->thumbnail) : asset('images/default-thumbnail.jpg') }}"
                                                alt="{{ $relatedArticle->title }}">
                                        </div>
                                        <div class="related-article-content">
                                            <h4 class="related-article-title">{{ $relatedArticle->title }}</h4>
                                            <div class="related-article-meta">
                                                <span class="related-article-date">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    {{ $relatedArticle->published_at ? $relatedArticle->published_at->format('M d, Y') : 'Draft' }}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-center py-4">No related articles found.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Popular Categories Widget -->
                    <div class="sidebar-widget mt-8">
                        <h3 class="sidebar-widget-title">
                            <i class="fas fa-folder text-green-600 mr-2"></i>Categories
                        </h3>
                        <div class="category-list">
                            @if(isset($popularCategories) && count($popularCategories) > 0)
                                @foreach($popularCategories as $category)
                                    <a href="{{ route('categories.show', $category->slug) }}" class="category-list-item">
                                        <span class="category-name">{{ $category->name }}</span>
                                        <span class="category-count">{{ $category->articles_count }}</span>
                                    </a>
                                @endforeach
                            @else
                                <div class="category-list-item">
                                    @if($article->category)
                                        <a href="{{ route('categories.show', $article->category->slug) }}" class="category-name">
                                            {{ $article->category->name }}
                                        </a>
                                    @else
                                        <span class="category-name">Uncategorized</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <!-- Enhanced Comments Section -->
    <section class="comments-section">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="comments-header">
                    <h2 class="comments-title">Comments <span class="comments-count">{{ $article->commentsCount }}</span>
                    </h2>
                </div>

                <!-- Comment Form -->
                <div class="mb-8">
                    <!-- Google Sign-In Comment Form -->
                    <div id="comment-form-container" class="comment-form-container">
                        <div id="not-signed-in" class="comment-not-signed-in">
                            <p class="mb-4 text-center">Sign in with Google to leave a comment</p>
                            <div class="flex justify-center">
                                <div id="g_id_onload" data-client_id="{{ config('services.google.client_id') }}"
                                    data-callback="handleCredentialResponse">
                                </div>
                                <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline"
                                    data-text="sign_in_with" data-shape="rectangular" data-logo_alignment="center">
                                </div>
                            </div>
                        </div>

                        <div id="signed-in" class="comment-signed-in hidden">
                            <div class="comment-user-info">
                                <div class="comment-user-avatar">
                                    <img id="google-profile-picture" src="/placeholder.svg" alt="Profile Picture">
                                </div>
                                <div class="comment-user-details">
                                    <p class="comment-user-name" id="google-display-name"></p>
                                    <p class="comment-user-email" id="google-email"></p>
                                </div>
                                <button type="button" onclick="signOut()" class="comment-signout-button">
                                    Sign Out
                                </button>
                            </div>

                            <form id="google-comment-form" class="comment-form">
                                @csrf
                                <input type="hidden" name="name" id="comment-name">
                                <input type="hidden" name="email" id="comment-email">
                                <input type="hidden" name="google_token" id="comment-token">
                                <input type="hidden" name="profile_picture" id="comment-picture">

                                <div class="comment-form-field">
                                    <label for="body" class="comment-form-label">Leave a comment</label>
                                    <textarea id="body" name="body" rows="4" class="comment-form-textarea"
                                        placeholder="Share your thoughts..."></textarea>
                                </div>
                                <div class="comment-form-actions">
                                    <button type="submit" class="comment-submit-button">
                                        <i class="far fa-paper-plane mr-2"></i>Post Comment
                                    </button>
                                    <div id="comment-status" class="comment-status hidden"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Comments List with Enhanced Design -->
                <div class="comments-list">
                    @if(isset($article->comments) && count($article->comments) > 0)
                        @foreach($article->comments as $comment)
                            <div class="comment-card" data-aos="fade-up">
                                <div class="comment-main">
                                    <div class="comment-avatar">
                                        <img src="{{ $comment->profile_picture ?? asset('images/default-avatar.jpg') }}"
                                            alt="{{ $comment->name }}">
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-header">
                                            <h4 class="comment-author">{{ $comment->name }}</h4>
                                            <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="comment-body">
                                            {{ $comment->body }}
                                        </div>
                                        <div class="comment-actions">
                                            <button class="comment-action-button like-button" data-comment-id="{{ $comment->id }}">
                                                <i class="far fa-thumbs-up"></i>
                                                <span>Like</span>
                                                <span class="like-count">{{ $comment->likes_count }}</span>
                                            </button>
                                            <button class="comment-action-button reply-toggle" data-comment-id="{{ $comment->id }}">
                                                <i class="far fa-comment"></i> Reply
                                            </button>
                                        </div>

                                        <!-- Reply Form (Hidden by default) -->
                                        <div class="reply-form hidden" id="reply-form-{{ $comment->id }}">
                                            <!-- Google Sign-In Reply Form -->
                                            <div id="reply-container-{{ $comment->id }}">
                                                <div class="google-reply-not-signed-in">
                                                    <p class="text-sm text-gray-500 mb-2">Sign in with Google to reply</p>
                                                    <div class="g_id_signin" data-type="standard" data-size="medium"
                                                        data-theme="outline" data-text="sign_in_with" data-shape="rectangular"
                                                        data-callback="handleReplyCredentialResponse"
                                                        data-comment-id="{{ $comment->id }}" data-logo_alignment="left">
                                                    </div>
                                                </div>

                                                <div class="google-reply-signed-in hidden">
                                                    <div class="reply-user-info">
                                                        <div class="reply-user-avatar">
                                                            <img class="google-reply-profile-picture" src="/placeholder.svg"
                                                                alt="Profile Picture">
                                                        </div>
                                                        <p class="reply-user-name google-reply-display-name"></p>
                                                        <button type="button" onclick="signOutReply({{ $comment->id }})"
                                                            class="reply-signout-button">
                                                            Sign Out
                                                        </button>
                                                    </div>

                                                    <form class="google-reply-form">
                                                        @csrf
                                                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        <input type="hidden" name="name" class="reply-name">
                                                        <input type="hidden" name="email" class="reply-email">
                                                        <input type="hidden" name="google_token" class="reply-token">
                                                        <input type="hidden" name="profile_picture" class="reply-picture">

                                                        <div class="reply-form-field">
                                                            <textarea name="body" rows="2" class="reply-form-textarea"
                                                                placeholder="Write a reply..."></textarea>
                                                        </div>
                                                        <div class="reply-form-actions">
                                                            <button type="submit" class="reply-submit-button">
                                                                Reply
                                                            </button>
                                                            <button type="button" class="reply-cancel-button cancel-reply"
                                                                data-comment-id="{{ $comment->id }}">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Replies with Enhanced Design -->
                                        @if(isset($comment->replies) && count($comment->replies) > 0)
                                            <div class="replies-container">
                                                @foreach($comment->replies as $reply)
                                                    <div class="reply-card">
                                                        <div class="reply-avatar">
                                                            <img src="{{ $reply->profile_picture ?? asset('images/default-avatar.jpg') }}"
                                                                alt="{{ $reply->name }}">
                                                        </div>
                                                        <div class="reply-content">
                                                            <div class="reply-header">
                                                                <h5 class="reply-author">{{ $reply->name }}</h5>
                                                                <span class="reply-date">{{ $reply->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <div class="reply-body">
                                                                {{ $reply->body }}
                                                            </div>
                                                            <div class="reply-actions">
                                                                <button class="reply-action-button like-button"
                                                                    data-comment-id="{{ $reply->id }}">
                                                                    <i class="far fa-thumbs-up"></i>
                                                                    <span class="like-count">{{ $reply->likes_count }}</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-comments">
                            <div class="no-comments-icon">
                                <i class="far fa-comment-dots"></i>
                            </div>
                            <p class="no-comments-text">No comments yet. Be the first to share your thoughts!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Next/Previous Article Navigation -->
    <section class="article-navigation">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="article-navigation-container">
                    @if(isset($previousArticle))
                        <a href="{{ route('articles.show', ['category' => $previousArticle->category->slug, 'article' => $previousArticle->slug]) }}"
                            class="article-navigation-card prev" data-aos="fade-right">
                            <div class="article-navigation-direction">
                                <i class="fas fa-arrow-left"></i>
                                <span>Previous Article</span>
                            </div>
                            <h3 class="article-navigation-title">{{ $previousArticle->title }}</h3>
                            @if($previousArticle->category)
                                <span class="article-navigation-category">{{ $previousArticle->category->name }}</span>
                            @endif
                        </a>
                    @else
                        <div class="article-navigation-placeholder"></div>
                    @endif

                    @if(isset($nextArticle))
                        <a href="{{ route('articles.show', ['category' => $nextArticle->category->slug, 'article' => $nextArticle->slug]) }}"
                            class="article-navigation-card next" data-aos="fade-left">
                            <div class="article-navigation-direction">
                                <span>Next Article</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <h3 class="article-navigation-title">{{ $nextArticle->title }}</h3>
                            @if($nextArticle->category)
                                <span class="article-navigation-category">{{ $nextArticle->category->name }}</span>
                            @endif
                        </a>
                    @else
                        <div class="article-navigation-placeholder"></div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for Google Sign-In and interactivity -->
    <script>
        // Google Sign-In Handling
        let googleUser = null;

        // Initialize AOS and setup everything else when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-out',
                once: true
            });

            // Try to restore Google session from localStorage
            const savedSession = localStorage.getItem('googleUserSession');
            if (savedSession) {
                try {
                    googleUser = JSON.parse(savedSession);
                    console.log("Restored Google session:", googleUser);

                    // Update main comment form
                    updateCommentFormWithSession();

                    // Update all reply forms
                    updateReplyFormsWithSession();

                    // Update like buttons with active state if user has liked
                    updateLikeButtonsState();
                } catch (e) {
                    console.error("Error restoring session:", e);
                    localStorage.removeItem('googleUserSession');
                }
            }

            // Set up comment form submission
            setupCommentForm();

            // Set up reply forms
            setupReplyForms();

            // Set up like buttons
            setupLikeButtons();

            // Set up reading progress
            setupReadingProgress();

            // Set up reply toggles
            setupReplyToggles();
        });

        function handleCredentialResponse(response) {
            console.log("Google sign-in successful");

            // Decode the JWT token to get user information
            const responsePayload = parseJwt(response.credential);
            console.log("Google user data:", responsePayload);

            googleUser = {
                token: response.credential,
                id: responsePayload.sub,
                name: responsePayload.name,
                email: responsePayload.email,
                picture: responsePayload.picture
            };

            // Save to localStorage for persistence
            localStorage.setItem('googleUserSession', JSON.stringify(googleUser));

            // Update the UI
            updateCommentFormWithSession();

            console.log("Form fields updated with Google user data");
        }

        function updateCommentFormWithSession() {
            if (!googleUser) return;

            document.getElementById('not-signed-in').classList.add('hidden');
            document.getElementById('signed-in').classList.remove('hidden');
            document.getElementById('google-display-name').textContent = googleUser.name;
            document.getElementById('google-email').textContent = googleUser.email;
            document.getElementById('google-profile-picture').src = googleUser.picture;

            // Update form fields
            document.getElementById('comment-name').value = googleUser.name;
            document.getElementById('comment-email').value = googleUser.email;
            document.getElementById('comment-token').value = googleUser.token;
            document.getElementById('comment-picture').value = googleUser.picture;
        }

        function updateReplyFormsWithSession() {
            if (!googleUser) return;

            // Find all reply containers
            const replyContainers = document.querySelectorAll('[id^="reply-container-"]');

            replyContainers.forEach(container => {
                const notSignedIn = container.querySelector('.google-reply-not-signed-in');
                const signedIn = container.querySelector('.google-reply-signed-in');

                if (notSignedIn && signedIn) {
                    notSignedIn.classList.add('hidden');
                    signedIn.classList.remove('hidden');

                    // Update display elements
                    const displayName = signedIn.querySelector('.google-reply-display-name');
                    const profilePicture = signedIn.querySelector('.google-reply-profile-picture');

                    if (displayName) displayName.textContent = googleUser.name;
                    if (profilePicture) profilePicture.src = googleUser.picture;

                    // Update form fields
                    const nameField = signedIn.querySelector('.reply-name');
                    const emailField = signedIn.querySelector('.reply-email');
                    const tokenField = signedIn.querySelector('.reply-token');
                    const pictureField = signedIn.querySelector('.reply-picture');

                    if (nameField) nameField.value = googleUser.name;
                    if (emailField) emailField.value = googleUser.email;
                    if (tokenField) tokenField.value = googleUser.token;
                    if (pictureField) pictureField.value = googleUser.picture;
                }
            });
        }

        function handleReplyCredentialResponse(response) {
            // Decode the JWT token to get user information
            const responsePayload = parseJwt(response.credential);
            const commentId = event.currentTarget.getAttribute('data-comment-id');
            const replyContainer = document.getElementById('reply-container-' + commentId);

            console.log("Reply sign-in successful for comment ID:", commentId);

            // Store user data
            googleUser = {
                token: response.credential,
                id: responsePayload.sub,
                name: responsePayload.name,
                email: responsePayload.email,
                picture: responsePayload.picture
            };

            // Save to localStorage for persistence
            localStorage.setItem('googleUserSession', JSON.stringify(googleUser));

            // Update the UI for this specific reply form
            const notSignedIn = replyContainer.querySelector('.google-reply-not-signed-in');
            const signedIn = replyContainer.querySelector('.google-reply-signed-in');

            if (notSignedIn && signedIn) {
                notSignedIn.classList.add('hidden');
                signedIn.classList.remove('hidden');

                // Update display elements
                const displayName = signedIn.querySelector('.google-reply-display-name');
                const profilePicture = signedIn.querySelector('.google-reply-profile-picture');

                if (displayName) displayName.textContent = googleUser.name;
                if (profilePicture) profilePicture.src = googleUser.picture;

                // Update form fields
                const nameField = signedIn.querySelector('.reply-name');
                const emailField = signedIn.querySelector('.reply-email');
                const tokenField = signedIn.querySelector('.reply-token');
                const pictureField = signedIn.querySelector('.reply-picture');

                if (nameField) nameField.value = googleUser.name;
                if (emailField) emailField.value = googleUser.email;
                if (tokenField) tokenField.value = googleUser.token;
                if (pictureField) pictureField.value = googleUser.picture;
            }

            // Also update the main comment form
            updateCommentFormWithSession();
        }

        function parseJwt(token) {
            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            const jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
            return JSON.parse(jsonPayload);
        }

        function signOut() {
            googleUser = null;
            localStorage.removeItem('googleUserSession');

            document.getElementById('not-signed-in').classList.remove('hidden');
            document.getElementById('signed-in').classList.add('hidden');
            document.getElementById('google-comment-form').reset();

            // Clear form fields
            document.getElementById('comment-name').value = '';
            document.getElementById('comment-email').value = '';
            document.getElementById('comment-token').value = '';
            document.getElementById('comment-picture').value = '';

            // Revoke Google authentication
            google.accounts.id.disableAutoSelect();
        }

        function signOutReply(commentId) {
            const replyContainer = document.getElementById('reply-container-' + commentId);
            const notSignedIn = replyContainer.querySelector('.google-reply-not-signed-in');
            const signedIn = replyContainer.querySelector('.google-reply-signed-in');

            notSignedIn.classList.remove('hidden');
            signedIn.classList.add('hidden');

            // Clear form fields
            const form = signedIn.querySelector('.google-reply-form');
            form.reset();
        }

        function setupCommentForm() {
            const commentForm = document.getElementById('google-comment-form');
            const commentStatus = document.getElementById('comment-status');

            if (commentForm) {
                commentForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Get form data
                    const formData = new FormData(this);

                    // Show loading state
                    const submitButton = commentForm.querySelector('button[type="submit"]');
                    const originalButtonText = submitButton.textContent;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Posting...';
                    submitButton.disabled = true;

                    // Send AJAX request
                    fetch('{{ route("comments.store", $article) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                if (!response.headers.get('content-type')?.includes('application/json')) {
                                    return response.text().then(text => {
                                        throw new Error('Server returned non-JSON response. Check server logs.');
                                    });
                                }
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                showCommentStatus('Comment posted successfully! Refreshing page...', 'success');

                                // Refresh the page after a short delay to show the new comment
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                // Show error message
                                showCommentStatus(data.message || 'An error occurred. Please try again.', 'error');
                                submitButton.innerHTML = originalButtonText;
                                submitButton.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showCommentStatus('An error occurred: ' + error.message, 'error');
                            submitButton.innerHTML = originalButtonText;
                            submitButton.disabled = false;
                        });
                });
            }
        }

        function showCommentStatus(message, type) {
            const commentStatus = document.getElementById('comment-status');
            if (!commentStatus) return;

            commentStatus.textContent = message;
            commentStatus.classList.remove('hidden', 'text-green-600', 'text-red-600');

            if (type === 'success') {
                commentStatus.classList.add('text-green-600');
            } else {
                commentStatus.classList.add('text-red-600');
            }
        }

        function setupReplyForms() {
            const replyForms = document.querySelectorAll('.google-reply-form');

            replyForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Get form data
                    const formData = new FormData(form);

                    // Add CSRF token
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                    // Show loading state
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalButtonText = submitButton.textContent;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Posting...';
                    submitButton.disabled = true;

                    // Remove any previous status messages
                    const previousStatus = form.querySelector('.reply-status');
                    if (previousStatus) {
                        previousStatus.remove();
                    }

                    // Send AJAX request
                    fetch('{{ route("comments.reply") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                if (!response.headers.get('content-type')?.includes('application/json')) {
                                    return response.text().then(text => {
                                        throw new Error('Server returned non-JSON response. Check server logs.');
                                    });
                                }
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                const statusDiv = document.createElement('div');
                                statusDiv.className = 'reply-status success';
                                statusDiv.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Reply posted successfully! Refreshing page...';
                                form.appendChild(statusDiv);

                                // Refresh the page after a short delay to show the new reply
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                // Show error message
                                const statusDiv = document.createElement('div');
                                statusDiv.className = 'reply-status error';
                                statusDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i> ' + (data.message || 'An error occurred. Please try again.');
                                form.appendChild(statusDiv);
                                submitButton.textContent = originalButtonText;
                                submitButton.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            const statusDiv = document.createElement('div');
                            statusDiv.className = 'reply-status error';
                            statusDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i> An error occurred: ' + error.message;
                            form.appendChild(statusDiv);
                            submitButton.textContent = originalButtonText;
                            submitButton.disabled = false;
                        });
                });
            });
        }

        function setupReadingProgress() {
            const progressBar = document.getElementById('readingProgressBar');
            const articleContent = document.querySelector('.article-body');

            if (progressBar && articleContent) {
                window.addEventListener('scroll', function () {
                    const articleRect = articleContent.getBoundingClientRect();
                    const articleStart = articleRect.top;
                    const articleEnd = articleRect.bottom;
                    const windowHeight = window.innerHeight;

                    // Calculate how much of the article has been read
                    let readingProgress = 0;

                    if (articleStart < 0) {
                        const totalArticleHeight = articleEnd - articleStart;
                        const readHeight = Math.min(windowHeight - articleStart, totalArticleHeight);
                        readingProgress = (readHeight / totalArticleHeight) * 100;
                    }

                    // Ensure progress is between 0 and 100
                    readingProgress = Math.max(0, Math.min(100, readingProgress));
                    progressBar.style.width = readingProgress + '%';
                });
            }
        }

        function setupReplyToggles() {
            const replyToggles = document.querySelectorAll('.reply-toggle');
            const cancelReplies = document.querySelectorAll('.cancel-reply');

            replyToggles.forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const commentId = this.getAttribute('data-comment-id');
                    const replyForm = document.getElementById('reply-form-' + commentId);
                    replyForm.classList.toggle('hidden');

                    // If user is logged in, update the reply form with their info
                    if (googleUser && replyForm.classList.contains('hidden') === false) {
                        const replyContainer = document.getElementById('reply-container-' + commentId);
                        if (replyContainer) {
                            const notSignedIn = replyContainer.querySelector('.google-reply-not-signed-in');
                            const signedIn = replyContainer.querySelector('.google-reply-signed-in');

                            if (notSignedIn && signedIn) {
                                notSignedIn.classList.add('hidden');
                                signedIn.classList.remove('hidden');

                                // Update display elements
                                const displayName = signedIn.querySelector('.google-reply-display-name');
                                const profilePicture = signedIn.querySelector('.google-reply-profile-picture');

                                if (displayName) displayName.textContent = googleUser.name;
                                if (profilePicture) profilePicture.src = googleUser.picture;

                                // Update form fields
                                const nameField = signedIn.querySelector('.reply-name');
                                const emailField = signedIn.querySelector('.reply-email');
                                const tokenField = signedIn.querySelector('.reply-token');
                                const pictureField = signedIn.querySelector('.reply-picture');

                                if (nameField) nameField.value = googleUser.name;
                                if (emailField) emailField.value = googleUser.email;
                                if (tokenField) tokenField.value = googleUser.token;
                                if (pictureField) pictureField.value = googleUser.picture;
                            }
                        }
                    }
                });
            });

            cancelReplies.forEach(cancel => {
                cancel.addEventListener('click', function () {
                    const commentId = this.getAttribute('data-comment-id');
                    const replyForm = document.getElementById('reply-form-' + commentId);
                    replyForm.classList.add('hidden');
                });
            });
        }

        function setupLikeButtons() {
            const likeButtons = document.querySelectorAll('.like-button');

            likeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    if (!googleUser) {
                        alert('Please sign in to like comments');
                        return;
                    }

                    const commentId = this.getAttribute('data-comment-id');
                    const likeCount = this.querySelector('.like-count');
                    const likeIcon = this.querySelector('i');

                    // Add pulse animation
                    likeIcon.classList.add('like-pulse');

                    // Get Google token if available
                    let formData = new FormData();
                    formData.append('google_token', googleUser.token);

                    // Send AJAX request
                    fetch(`/comments/${commentId}/like`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                if (!response.headers.get('content-type')?.includes('application/json')) {
                                    return response.text().then(text => {
                                        throw new Error('Server returned non-JSON response');
                                    });
                                }
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Update like count with animation
                            const oldCount = parseInt(likeCount.textContent);
                            const newCount = data.likes_count;

                            if (oldCount !== newCount) {
                                likeCount.classList.add('count-change');
                                likeCount.textContent = newCount;

                                // Remove animation class after animation completes
                                setTimeout(() => {
                                    likeCount.classList.remove('count-change');
                                }, 500);
                            }

                            // Toggle active class with animation
                            if (data.action === 'liked') {
                                likeIcon.classList.remove('far');
                                likeIcon.classList.add('fas', 'like-active');
                                button.classList.add('text-primary-600');
                            } else {
                                likeIcon.classList.remove('fas', 'like-active');
                                likeIcon.classList.add('far');
                                button.classList.remove('text-primary-600');
                            }

                            // Remove pulse animation
                            setTimeout(() => {
                                likeIcon.classList.remove('like-pulse');
                            }, 500);

                            // Store liked state in localStorage
                            updateLikedComments(commentId, data.action === 'liked');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Remove pulse animation
                            likeIcon.classList.remove('like-pulse');
                        });
                });
            });
        }

        function updateLikedComments(commentId, isLiked) {
            if (!googleUser) return;

            let likedComments = {};
            const savedLikes = localStorage.getItem(`likedComments_${googleUser.id}`);

            if (savedLikes) {
                try {
                    likedComments = JSON.parse(savedLikes);
                } catch (e) {
                    console.error('Error parsing liked comments:', e);
                }
            }

            if (isLiked) {
                likedComments[commentId] = true;
            } else {
                delete likedComments[commentId];
            }

            localStorage.setItem(`likedComments_${googleUser.id}`, JSON.stringify(likedComments));
        }

        function updateLikeButtonsState() {
            if (!googleUser) return;

            const savedLikes = localStorage.getItem(`likedComments_${googleUser.id}`);
            if (!savedLikes) return;

            try {
                const likedComments = JSON.parse(savedLikes);

                const likeButtons = document.querySelectorAll('.like-button');
                likeButtons.forEach(button => {
                    const commentId = button.getAttribute('data-comment-id');

                    if (likedComments[commentId]) {
                        const likeIcon = button.querySelector('i');
                        if (likeIcon) {
                            likeIcon.classList.remove('far');
                            likeIcon.classList.add('fas');
                            button.classList.add('text-primary-600');
                        }
                    }
                });
            } catch (e) {
                console.error('Error updating like buttons state:', e);
            }
        }

        // Social Share Functions
        function shareArticle(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);

            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        }

        function copyArticleLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                // Show a toast notification
                const toast = document.createElement('div');
                toast.className = 'copy-toast';
                toast.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Link copied to clipboard!';
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('show');

                    setTimeout(() => {
                        toast.classList.remove('show');
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 300);
                    }, 2000);
                }, 10);
            });
        }
    </script>

    <!-- CSS Styles -->
    <style>
        /* Reading Progress Bar */
        .reading-progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .reading-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #2e7d32, #4CAF50);
            width: 0%;
            transition: width 0.1s ease;
        }

        /* Article Header */
        .article-header {
            min-height: 70vh;
            display: flex;
            align-items: center;
            color: white;
            overflow: hidden;
        }

        .article-header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        .article-header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.8) 100%);
        }

        /* Category Badge */
        .category-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .category-badge:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Tags */
        .tag-pill {
            display: inline-flex;
            align-items: center;
            background: #f3f4f6;
            color: #4b5563;
            padding: 0.35rem 0.85rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .tag-pill:hover {
            background: #4CAF50;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        /* Copy Toast */
        .copy-toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: #1f2937;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.875rem;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
        }

        .copy-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* Article Content */
        .article-body {
            font-size: 1.125rem;
            line-height: 1.8;
        }

        .article-body h2 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-top: 2.5rem;
            margin-bottom: 1.25rem;
            color: #2e7d32;
        }

        .article-body h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #2e7d32;
        }

        .article-body p {
            margin-bottom: 1.5rem;
        }

        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin: 2rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .article-body img:hover {
            transform: scale(1.01);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .article-body blockquote {
            border-left: 4px solid #4CAF50;
            padding: 1rem 1.5rem;
            font-style: italic;
            color: #4b5563;
            margin: 2rem 0;
            background: #f9fafb;
            border-radius: 0 0.5rem 0.5rem 0;
        }

        .article-body a {
            color: #2e7d32;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 2px;
            transition: all 0.2s ease;
        }

        .article-body a:hover {
            color: #4CAF50;
        }

        /* Redesigned Author Card */
        .author-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-align: center;
            padding: 2rem;
        }

        .author-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .author-card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .author-avatar-container {
            margin-bottom: 1.5rem;
        }

        .author-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid #f3f4f6;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            background-color: #f3f4f6;
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .author-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .author-role {
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .author-bio {
            color: #4b5563;
            font-size: 1rem;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Mobile Share */
        .mobile-share-container {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .mobile-share-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            text-align: center;
        }

        .mobile-share-buttons {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .mobile-share-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: #4b5563;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .mobile-share-button:hover {
            transform: translateY(-2px);
        }

        .mobile-share-button.facebook:hover {
            background: #1877f2;
            color: white;
        }

        .mobile-share-button.twitter:hover {
            background: #1da1f2;
            color: white;
        }

        .mobile-share-button.linkedin:hover {
            background: #0a66c2;
            color: white;
        }

        .mobile-share-button.whatsapp:hover {
            background: #25D366;
            color: white;
        }

        .mobile-share-button.copy-link:hover {
            background: #6366f1;
            color: white;
        }

        /* Sidebar Share Buttons */
        .sidebar-share-button {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #4b5563;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar-share-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-share-button.facebook:hover {
            background: #1877f2;
            color: white;
        }

        .sidebar-share-button.twitter:hover {
            background: #1da1f2;
            color: white;
        }

        .sidebar-share-button.linkedin:hover {
            background: #0a66c2;
            color: white;
        }

        .sidebar-share-button.whatsapp:hover {
            background: #25D366;
            color: white;
        }

        .sidebar-share-button.copy-link:hover {
            background: #6366f1;
            color: white;
        }

        /* Sidebar Widgets */
        .sidebar-widget {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .sidebar-widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .sidebar-widget-title {
            padding: 1.25rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
        }

        /* Related Articles */
        .related-article-card {
            display: flex;
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.3s ease;
        }

        .related-article-card:last-child {
            border-bottom: none;
        }

        .related-article-card:hover {
            background: #f9fafb;
        }

        .related-article-image {
            width: 70px;
            height: 70px;
            border-radius: 0.5rem;
            overflow: hidden;
            flex-shrink: 0;
        }

        .related-article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .related-article-card:hover .related-article-image img {
            transform: scale(1.05);
        }

        .related-article-content {
            margin-left: 1rem;
            flex: 1;
        }

        .related-article-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .related-article-card:hover .related-article-title {
            color: #2e7d32;
        }

        .related-article-meta {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Category List */
        .category-list {
            padding: 0.5rem;
        }

        .category-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .category-list-item:hover {
            background: #f3f4f6;
        }

        .category-name {
            font-size: 0.875rem;
            color: #4b5563;
            transition: all 0.3s ease;
        }

        .category-list-item:hover .category-name {
            color: #2e7d32;
        }

        .category-count {
            background: #f3f4f6;
            color: #4b5563;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .category-list-item:hover .category-count {
            background: #2e7d32;
            color: white;
        }

        /* Comments Section */
        .comments-section {
            background: #f9fafb;
            padding: 4rem 0;
        }

        .comments-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .comments-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            display: inline-flex;
            align-items: center;
        }

        .comments-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2e7d32;
            color: white;
            font-size: 1rem;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            margin-left: 0.75rem;
        }

        .comment-form-container {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .comment-not-signed-in {
            text-align: center;
            padding: 1.5rem;
        }

        .comment-signed-in {
            width: 100%;
        }

        .comment-user-info {
            display: flex;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .comment-user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1rem;
        }

        .comment-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comment-user-details {
            flex: 1;
        }

        .comment-user-name {
            font-weight: 600;
            color: #1f2937;
        }

        .comment-user-email {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .comment-signout-button {
            font-size: 0.875rem;
            color: #6b7280;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .comment-signout-button:hover {
            color: #ef4444;
        }

        .comment-form {
            width: 100%;
        }

        .comment-form-field {
            margin-bottom: 1rem;
        }

        .comment-form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }

        .comment-form-textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            resize: vertical;
            min-height: 100px;
            transition: all 0.3s ease;
        }

        .comment-form-textarea:focus {
            outline: none;
            border-color: #2e7d32;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        }

        .comment-form-actions {
            display: flex;
            align-items: center;
        }

        .comment-submit-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2e7d32;
            color: white;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .comment-submit-button:hover {
            background: #1b5e20;
        }

        .comment-status {
            margin-left: 1rem;
            font-size: 0.875rem;
        }

        /* Comments List */
        .comments-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .comment-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .comment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .comment-main {
            display: flex;
            padding: 1.5rem;
        }

        .comment-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .comment-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comment-content {
            margin-left: 1rem;
            flex: 1;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .comment-author {
            font-weight: 600;
            color: #1f2937;
        }

        .comment-date {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .comment-body {
            color: #4b5563;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .comment-actions {
            display: flex;
            gap: 1rem;
        }

        .comment-action-button {
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            color: #6b7280;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0.25rem 0;
        }

        .comment-action-button:hover {
            color: #2e7d32;
        }

        .comment-action-button i {
            margin-right: 0.5rem;
        }

        .like-count {
            margin-left: 0.25rem;
            font-size: 0.75rem;
            background: #f3f4f6;
            color: #4b5563;
            padding: 0.125rem 0.375rem;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .comment-action-button:hover .like-count {
            background: #dcfce7;
            color: #2e7d32;
        }

        /* Reply Form */
        .reply-form {
            margin-top: 1rem;
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 0.5rem;
        }

        .reply-user-info {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .reply-user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 0.5rem;
        }

        .reply-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reply-user-name {
            font-size: 0.75rem;
            font-weight: 500;
            color: #4b5563;
            flex: 1;
        }

        .reply-signout-button {
            font-size: 0.75rem;
            color: #6b7280;
            background: none;
            border: none;
            cursor: pointer;
        }

        .reply-form-field {
            margin-bottom: 0.75rem;
        }

        .reply-form-textarea {
            width: 100%;
            padding: 0.625rem;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            resize: vertical;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .reply-form-textarea:focus {
            outline: none;
            border-color: #2e7d32;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        }

        .reply-form-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .reply-submit-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2e7d32;
            color: white;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .reply-submit-button:hover {
            background: #1b5e20;
        }

        .reply-cancel-button {
            font-size: 0.75rem;
            color: #6b7280;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .reply-cancel-button:hover {
            color: #ef4444;
        }

        /* Replies */
        .replies-container {
            margin-top: 1rem;
            padding-left: 1rem;
            border-left: 2px solid #e5e7eb;
        }

        .reply-card {
            display: flex;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .reply-card:last-child {
            border-bottom: none;
        }

        .reply-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .reply-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reply-content {
            margin-left: 0.75rem;
            flex: 1;
        }

        .reply-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.25rem;
        }

        .reply-author {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
        }

        .reply-date {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .reply-body {
            font-size: 0.875rem;
            color: #4b5563;
            margin-bottom: 0.5rem;
            line-height: 1.5;
        }

        .reply-actions {
            display: flex;
            gap: 0.75rem;
        }

        .reply-action-button {
            display: inline-flex;
            align-items: center;
            font-size: 0.75rem;
            color: #6b7280;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .reply-action-button:hover {
            color: #2e7d32;
        }

        /* No Comments */
        .no-comments {
            background: white;
            border-radius: 1rem;
            padding: 3rem 1.5rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .no-comments-icon {
            font-size: 3rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .no-comments-text {
            color: #6b7280;
        }

        /* Article Navigation */
        .article-navigation {
            padding: 4rem 0;
            background: white;
        }

        .article-navigation-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .article-navigation-card {
            background: #f9fafb;
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .article-navigation-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, #2e7d32, #4CAF50);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .article-navigation-card:hover {
            background: #f3f4f6;
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .article-navigation-card:hover::after {
            transform: scaleX(1);
        }

        .article-navigation-direction {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.75rem;
        }

        .article-navigation-card.prev .article-navigation-direction {
            justify-content: flex-start;
        }

        .article-navigation-card.next .article-navigation-direction {
            justify-content: flex-end;
        }

        .article-navigation-card.prev .article-navigation-direction i {
            margin-right: 0.5rem;
        }

        .article-navigation-card.next .article-navigation-direction i {
            margin-left: 0.5rem;
        }

        .article-navigation-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            transition: all 0.3s ease;
        }

        .article-navigation-card:hover .article-navigation-title {
            color: #2e7d32;
        }

        .article-navigation-category {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: auto;
            padding-top: 0.75rem;
        }

        .article-navigation-placeholder {
            min-height: 1px;
        }

        /* Like Animation */
        .like-pulse {
            animation: like-pulse-animation 0.5s ease-in-out;
        }

        @keyframes like-pulse-animation {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.5);
            }

            100% {
                transform: scale(1);
            }
        }

        .like-active {
            color: #2e7d32;
            animation: like-active-animation 0.5s ease-in-out;
        }

        @keyframes like-active-animation {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .count-change {
            animation: count-change-animation 0.5s ease-in-out;
        }

        @keyframes count-change-animation {
            0% {
                opacity: 0.5;
                transform: scale(0.8);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .article-header {
                min-height: 50vh;
            }

            .article-navigation-container {
                grid-template-columns: 1fr;
            }

            .comment-main {
                flex-direction: column;
            }

            .comment-avatar {
                margin-bottom: 1rem;
            }

            .comment-content {
                margin-left: 0;
            }

            .author-avatar {
                width: 100px;
                height: 100px;
            }
        }

        @media (max-width: 640px) {
            .comment-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .comment-date {
                margin-top: 0.25rem;
            }

            .author-card {
                padding: 1.5rem 1rem;
            }

            .author-avatar {
                width: 80px;
                height: 80px;
            }

            .author-name {
                font-size: 1.25rem;
            }

            .author-role {
                font-size: 0.875rem;
            }
        }
    </style>
@endsection

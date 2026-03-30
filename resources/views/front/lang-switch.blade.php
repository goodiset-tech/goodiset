<style>
    .locale-switcher {
        position: relative;
    }

    .inline-lang-display {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 16px;
    }

    .inline-lang-display span {
        color: #303030;
        font-weight: 500;
    }

    .inline-lang-display span.active {
        color: #d7002c;
        /* highlighted red */
        font-weight: 700;
    }

    .inline-lang-display .divider {
        color: #888;
    }

    /* Hide the button (dropdown trigger) but keep it for JS */
    .locale-btn {
        display: none !important;
    }

    /* Dropdown menu will still work with JS */
    .locale-menu {
        position: absolute;
        background: white;
        border: 1px solid #ddd;
        padding: 6px 0;
        min-width: 100px;
        display: none;
        z-index: 999;
    }

    .locale-menu a {
        display: block;
        padding: 6px 12px;
        color: #303030;
        text-decoration: none;
    }

    .locale-menu a.active {
        color: #d7002c;
        font-weight: 700;
    }
</style>
<div class="locale-switcher" id="localeSwitcher">
    <button type="button" class="locale-btn" aria-haspopup="true" aria-expanded="false">
        @if (app()->getLocale() === 'en')
            English
        @else
            العربية
        @endif
        <i class="fa-solid fa-angle-down"></i>
    </button>

    <ul class="locale-menu">
        <li>
            <a href="#" data-locale="en" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">
                English
            </a>
        </li>
        <li>
            <a href="#" data-locale="ar" class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">
                العربية
            </a>
        </li>
    </ul>

    <!-- Inline fake UI (like screenshot) -->
    <div class="inline-lang-display">
        <span class="{{ app()->getLocale() === 'en' ? 'active' : '' }}" data-locale="en">English</span>
        <span class="divider">|</span>
        <span class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}" data-locale="ar">العربية</span>
    </div>
</div>

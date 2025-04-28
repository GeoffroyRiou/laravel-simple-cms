<nav class="header-menu" :class="{ 'is-active': showMenu }">
    <div class="header-menu__topbar">
        <div class="text">menu</div>
        <button type="button" aria-label="Fermer le menu" class="close" x-on:click="showMenu = false">
            <x-icon-close class="icon" />
        </button>
    </div>
    <div class="header-menu__body">
        <x-menu :menuId="2" class="header-menu__body__menu" />

        <div class="header-menu__body__footer">

            <div class="section">
                <x-contact-stripe class="text-white flex flex-col gap-3" />
            </div>

            <div class="section">
                <x-menu :menuId="1" class="header-menu__body__footer__buttons" />
                <x-language-switcher class="is-light"/>
            </div>

        </div>

    </div>
</nav>

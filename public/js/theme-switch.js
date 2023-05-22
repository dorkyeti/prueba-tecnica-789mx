$(document).ready(function () {
    // Obtiene el tema que tiene el sistema operativo
    const preferredColorScheme = () =>
        window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

    const setTheme = (theme) => {
        theme = theme == 'auto' ? preferredColorScheme() : schema

        if (theme == 'dark') {
            $(document).find('html')
                .removeClass('light-layout')
                .addClass('dark-layout');
        } else if (theme == 'light') {
            $(document).find('html')
                .removeClass('dark-layout')
                .addClass('light-layout');
        }
    }

    setTheme('auto');
});
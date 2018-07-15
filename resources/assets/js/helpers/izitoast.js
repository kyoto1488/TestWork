import izitoast from 'izitoast';

const defaultValue = {
    theme: 'light',
    close: true,
    position: 'bottomRight',
    timeout: 10000,
    animateInside: true,
    drag: true,
    pauseOnHover: true,
    progressBar: true,
    progressBarEasing: 'linear',
    overlay: false,
    overlayClose: false,
    overlayColor: 'rgba(0, 0, 0, 0.6)',
    transitionIn: 'fadeInUp',
    transitionOut: 'fadeOut',
    transitionInMobile: 'fadeInUp',
    transitionOutMobile: 'fadeOutDown',
};

/**
 *
 * @param title
 * @param message
 */
export const error = (title, message, custom = {}) => {
    const options = Object.assign(
        {},
        defaultValue,
        {
            title,
            message,
            backgroundColor: 'rgb(255, 235, 235)',
            titleColor: 'rgb(45,50,55)',
            messageColor: 'rgb(37,40,50)'
        },
        custom
    );

    izitoast.error(options);
};

/**
 *
 * @param title
 * @param message
 */
export const info = (title, message, custom = {}) => {
    const options = Object.assign(
        {},
        defaultValue,
        {
            title,
            message,
            backgroundColor: 'rgb(245, 245, 255)',
            titleColor: 'rgb(45,50,55)',
            messageColor: 'rgb(37,40,50)'
        },
        custom
    );

    izitoast.info(options);
};
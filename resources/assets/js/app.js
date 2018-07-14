import axios from 'axios';
import izitoast from 'izitoast';
require('./bootstrap');

izitoast.settings({
    transitionIn: 'fadeInUp',
    transitionOut: 'fadeOut',
    transitionInMobile: 'fadeInUp',
    transitionOutMobile: 'fadeOutDown',
    pauseOnHover: true,
    timeout: 8000,
});

const errorToast = (title, message) => {
    izitoast.error({
        title,
        message,
        backgroundColor: '#9f353a',
        messageColor: '#421a1e',
        titleColor: '#2b1515'
    })
};

const infoToast = (title, message) => {
    izitoast.error({
        title,
        message,
        backgroundColor: '#ffffff',
        messageColor: '#5b5b5b',
        titleColor: '#686868'
    })
};

(() => {
    $('#form-create-link').on('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();
        const $link = $(this).find('#link');
        const $lifetime = $(this).find('#lifetime');
        const $active = $(this).find('#active');
        const $buttonSubmit = $(this).find('[type="submit"]');

        const link = $link.val();
        const lifetime = $lifetime.val();
        const active = $active.val();

        $link.val('');
        $lifetime.val('');

        $buttonSubmit.attr('disabled', 'disabled');

        axios.post($(this).attr('action'), {
            'link': link,
            'lifetime': lifetime,
            'active': active
        })
            .then(response => {
                $buttonSubmit.removeAttr('disabled');
                infoToast('Link created', 'Your short link ' + response.data.link);
            })
            .catch(() => {
                $buttonSubmit.removeAttr('disabled');
                errorToast('Error create', 'Please, try again');
            })
    });
})();

(() => {
    let $container = $('#links-container');
    let interval = null;

    const sendRequest = () => {
        axios.get($container.attr('data-provider'))
            .then(response => {
                $container.html('');

                if (response.data.length === 0) {
                    $container.html(`
                        <div class="text-center mt-5">
                            <h5 class="font-weight-normal mb-0">
                                Nothing!
                            </h5>
                            <h6 class="font-weight-light">
                                add link in left block
                            </h6>
                        </div>
                    `);
                }

                for (let item of response.data) {
                    const $linkItem = $('<div>');
                    $linkItem.addClass('link-item');
                    $linkItem.addClass('mb-3');

                    const $shortLink = $('<p>');
                    $shortLink.addClass('text-dark');
                    $shortLink.addClass('mb-0');
                    $shortLink.addClass('small');
                    $shortLink.html(`<a class="text-muted" href="${ item.short_link }">${ item.short_link }</a>`);

                    const $originalLink = $('<p>');
                    $originalLink.addClass('text-muted');
                    $originalLink.addClass('mb-1');
                    $originalLink.addClass('small');
                    $originalLink.html(`<a class="text-muted" href="${ item.original }">${ item.original }</a>`);

                    const $info = $('<p>');
                    $info.addClass('text-secondary');
                    $info.addClass('small');
                    $info.addClass('mb-2');

                    let isActive = false;

                    if (item.lifetime) {
                        if (item.is_dead) {
                            isActive = false;
                            $info.html('Неактивна по окончанию срока существования');
                        } else {
                            $info.html((item.active === 1 ? 'Активна | ' : 'Неактивна | ') + item.lifetime);
                            isActive = item.active === 1;
                        }
                    } else {
                        $info.html(item.active === 1 ? 'Активна' : 'Неактивна');
                        isActive = item.active === 1;
                    }

                    const $actions = $('<div>');
                    $actions.addClass('actions');
                    $actions.addClass('actions d-flex');

                    const $buttonTrash = $('<button>');
                    $buttonTrash.attr({
                        'class': "d-block btn btn-sm btn-link",
                        'data-short': item.short
                    });
                    $buttonTrash.on('click', function () {
                        $(this).html('<i class="fas fa-trash text-muted fa-sm"></i>');
                        $(this).attr('disabled', 'disabled');

                        axios.post('/remove', { short_key: $(this).attr('data-short') });
                    });
                    $buttonTrash.html('<i class="fas fa-trash text-danger fa-sm"></i>');

                    const $buttonEdit = $('<button>');
                    $buttonEdit.attr({
                        'class': "d-block btn btn-sm btn-link"
                    });
                    $buttonEdit.on('click', function () {
                        location.href = item.short_link + '/edit';
                    });
                    $buttonEdit.html('<i class="fas fa-edit text-muted fa-sm"></i>');

                    const $buttonStat = $('<button>');
                    $buttonStat.attr({
                        'class': "d-block btn btn-sm btn-link"
                    });
                    $buttonStat.on('click', function () {
                        location.href = item.short_link + '/stat';
                    });
                    $buttonStat.html('<i class="fas fa-grin-stars text-muted fa-sm"></i>');

                    const $state = $('<button>');
                    $state.attr({
                        'class': 'd-block disabled btn btn-sm btn-link ml-auto',
                        'disabled': 'disabled'
                    });
                    $state.html('<i class="fas fa-check-circle text-primary fa-sm"></i>');

                    $shortLink.appendTo($linkItem);
                    $originalLink.appendTo($linkItem);
                    $info.appendTo($linkItem);


                    $buttonTrash.appendTo($actions);
                    $buttonEdit.appendTo($actions);
                    $buttonStat.appendTo($actions);

                    if (isActive) {
                        $state.appendTo($actions);
                    }

                    $actions.appendTo($linkItem);

                    $linkItem.appendTo($container);
                }
            })
            .catch(() => clearInterval(interval));
    };

    sendRequest();
    interval = setInterval(sendRequest, 3000);
})();
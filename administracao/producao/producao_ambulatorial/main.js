const letras = {
    1: "A", 2: "S", 3: "D", 4: "F", 5: "G", 6: "H", 7: "J", 8: "K", 9: "L", 10: "Ç", 11: "Z", 12: "X", 13: "C", 14: "V", 15: "B"
};

$(document).ready(function () {
    populaDados("um", "dadosPessoais", "n");
    populaDados("dois", "faixaEtaria", "n");
    populaDados("tres", "sexo", "n");
    populaDados("quatro", "cartaoSUS", "n");
    populaDados("cinco", "classificacaoRisco", "n");
    populaDados("seis", "acidentesTransito", "n");
    populaDados("sete", "causasAcidente", "n");
    populaDados("oito", "quedas", "n");
    populaDados("nove", "anamnese", "s");
    populaDados("dez", "consultas", "s");

    var owl = $("#owl-carousel").owlCarousel({
        items: 1,
        loop: true,
        nav: false,
        dots: false,
        autoPlay: false
    });

    function updateActiveClass() {
        $('.owl-item').removeClass('active');
        var currentIndex = owl.data('owlCarousel').currentItem;
        $('.owl-item').eq(currentIndex).addClass('active');
        
        if (currentIndex === 10) {
            const searchBox = document.querySelector('.search-box');
            setTimeout(() => {
                searchBox.focus();
                searchBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        }
    }

    function proximo() {
        owl.trigger('owl.next');
        updateActiveClass();
    }

    owl.on('changed.owl.carousel', updateActiveClass);
    updateActiveClass();

    $(document, ".iframe").keydown(function (event) {
        var key = event.key.toUpperCase();
        var activeItem = $(".owl-item.active .item");

        if (key === 'ENTER') {
            proximo();
        } else if (event.key === 'ArrowLeft') {
            owl.trigger('owl.prev');
            updateActiveClass();
        } else {
            activeItem.find('.count').each(function () {
                if ($(this).data('key') === key) {
                    var count = parseInt($(this).text());
                    if (event.shiftKey) {
                        count = count > 0 ? count - 1 : 0;
                    } else {
                        count++;
                    }
                    $(this).text(count);
                    if ($(this).data('multi') == "n") {
                        proximo();
                    }
                }
            });
        }
    });

    const searchBox = document.querySelector('.search-box');
    searchBox.addEventListener('input', function () {
        updateSuggestions(this);
    });

    searchBox.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            incrementCount(this.value);
            this.value = '';
            clearSuggestions();
            this.blur();
        }
    });
});

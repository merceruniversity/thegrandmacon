(function() {
    var onload = function() {
        var a,
            article,
            eventUrl,
            i,
            image,
            mecArticles = document.querySelectorAll('.mec-event-article'),
            mecLink,
            mecMasonryImage;
        
        for (i = 0; i < mecArticles.length; ++i) {
            article = mecArticles[i];
            mecLink = article.querySelector('a[data-event-id][href]');
            eventUrl = mecLink.getAttribute('href');
            mecMasonryImage = article.querySelector('.mec-masonry-img');
            image = mecMasonryImage.querySelector('img');
            a = document.createElement('a');
            a.setAttribute('href', eventUrl);
            a.appendChild(image);
            mecMasonryImage.appendChild(a);
        }
    };

    addEventListener('DOMContentLoaded', onload);
})();

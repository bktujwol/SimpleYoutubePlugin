'use strict';

var ytWidget = document.getElementById('youtube_widget_area');
var prevButton = document.getElementById('syt_prev_vid');
var nextButton = document.getElementById('syt_next_vid');
prevButton.setAttribute("onmouseover", "this.style.opacity = '0.8'");
prevButton.setAttribute("onmouseleave", "this.style.opacity = ''");

nextButton.setAttribute("onmouseover", "this.style.opacity = '0.8'");
nextButton.setAttribute("onmouseleave", "this.style.opacity = ''");

function sytChangeVideo(clickedEl) {

    let embedUrl = 'https://www.youtube.com/embed/';
    let vidNum = parseInt(clickedEl.getAttribute('data-vid-num'));
    let buttonId = clickedEl.getAttribute('id');
    let widgetDiv = document.getElementById('youtube_widget_area');
    let vidTitle = document.getElementById('syt-title-header');
    let vidIframe = widgetDiv.getElementsByTagName('iframe')[0];
    let prevButton = document.getElementById('syt_prev_vid');
    let nextButton = document.getElementById('syt_next_vid');
    let nextVidNum = vidNum + 1;
    let prevVidNum = vidNum - 1;
    let nextVid = widgetDiv.getAttribute('data-video-' + nextVidNum);
    let videoToLoadData = widgetDiv.getAttribute('data-video-' + vidNum).split(':syt:');

    if (prevVidNum === 0) {
        prevButton.style.display = 'none';
    } else {
        prevButton.style.display = 'inline-block';
    }

    if (buttonId === 'syt_next_vid') {

        prevButton.setAttribute('data-vid-num', prevVidNum)
        nextButton.setAttribute('data-vid-num', nextVidNum)
    } else {

        prevButton.setAttribute('data-vid-num', prevVidNum)
        nextButton.setAttribute('data-vid-num', nextVidNum)
    }

    if (nextVid === null) {
        nextButton.style.display = 'none';
    } else {
        nextButton.style.display = 'inline-block';
    }


    vidIframe.setAttribute('src', embedUrl + videoToLoadData[0]);
    vidTitle.innerHTML = videoToLoadData[1];
}

nextButton.addEventListener('click', function (event) {
    sytChangeVideo(this);
});


prevButton.addEventListener('click', function () {
    sytChangeVideo(this);
});
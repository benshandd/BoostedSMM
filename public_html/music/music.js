/**
 * cloutsy player
 * version: 0.2.1
 */

const playerMusics = [
	{
        name: 'A$AP Rocky - Praise The Lord (Da Shine)',
        src: 'https://cdn.smmspot.net/cloutsy/assets/music/song4.mp3',
        cover: 'https://cdn.smmspot.net/cloutsy/assets/music/song4.jpeg',
    },
    {
        name: 'WILLOW, THE ANXIETY, Tyler Cole - Meet Me At Our Spot',
        src: 'https://cdn.smmspot.net/cloutsy/assets/music/song8.mp3',
        cover: 'https://cdn.smmspot.net/cloutsy/assets/music/song8.jpeg',
    },
	{
        name: 'Doja Cat, SZA - Kiss Me More',
        src: 'https://cdn.smmspot.net/cloutsy/assets/music/song20.mp3',
        cover: 'https://cdn.smmspot.net/cloutsy/assets/music/song20.jpeg',
    },
	{
        name: 'NEIKED, Mae Muller, J Balvin - Better Days ft. Polo G',
        src: 'https://cdn.smmspot.net/cloutsy/assets/music/song9.mp3',
        cover: 'https://cdn.smmspot.net/cloutsy/assets/music/song9.jpeg',
    },
	{
        name: 'Doja Cat, The Weeknd - You Right',
        src: 'https://cdn.smmspot.net/cloutsy/assets/music/song18.mp3',
        cover: 'https://cdn.smmspot.net/cloutsy/assets/music/song18.jpeg',
    },
    	{
        name: 'Ed Sheeran - Shape of You',
        src: 'https://cdn.smmspot.net/cloutsy/assets/music/song14.mp3',
        cover: 'https://cdn.smmspot.net/cloutsy/assets/music/song14.jpeg',
    },
];

const sidebarPlayer = document.querySelector('.sidebar-player');
const [activeSong, setActiveSong] = useState(0);
const [autoPlay, setAutoPlay] = useState('disabled');
const [firstPlay, setFirstPlay] = useState('true');

if (sidebarPlayer) {
    const albumCover = sidebarPlayer.querySelector('.album-cover > img');
    const songName = sidebarPlayer.querySelector('.song-name');
    const autoPlayBtn = sidebarPlayer.querySelector('#sound-autoplay');
    const totalSongDom = sidebarPlayer.querySelector('#total-song');
    const currentSongDom = sidebarPlayer.querySelector('#current-song-order');

    totalSongDom.innerHTML = playerMusics.length;

    if (localStorage.getItem('activeSong')) {
        setActiveSong(parseInt(localStorage.getItem('activeSong')));
    }

    if (localStorage.getItem('autoPlay')) {
        setAutoPlay(localStorage.getItem('autoPlay'));
    } else {
        localStorage.setItem('autoPlay', 'enabled');
    }

    const songPosition = (localStorage.getItem('songPosition')) ? parseInt(localStorage.getItem('songPosition')) : 0;

    const setActive = () => {
        albumCover.src = `${playerMusics[activeSong()].cover}`;
        songName.innerHTML = playerMusics[activeSong()].name;
        currentSongDom.innerHTML = activeSong() + 1;
    }

    // prepare the player
    let pi = 0;
    var sound = [];
    playerMusics.forEach(music => {
        const soundItem = new Howl({
            src: [playerMusics[pi].src],
            html5: true,
            preload: false,
            onplay: function () {
                sidebarPlayer.classList.add('playing');
                if (firstPlay() == 'true') {
                    soundItem.seek(songPosition);
                    setFirstPlay('false');
                }
                // watch position
                var positionFunc = () => {
                    var duration = soundItem.duration();
                    var position = soundItem.seek();
                    localStorage.setItem('songPosition', position);
                    this.savePosition = setTimeout(() => positionFunc(), 1000);
                }
                positionFunc();
            },
            onstop: function () {
                clearTimeout(this.savePosition);
            },
            onpause: function () {
                sidebarPlayer.classList.remove('playing');
            },
            onend: function () {
                nextSong();
            }
        });
        sound.push(soundItem);
        pi++;
    })

    if (autoPlay() === 'enabled') {
        autoPlayBtn.classList.add('enabled');
        sound[activeSong()].play();
        setActive();
    } else {
        setActive();
    }

    // next song
    const nextSong = () => {
        sound[activeSong()].stop();
        if (activeSong() < playerMusics.length - 1) {
            setActiveSong(parseInt(activeSong()) + 1);
        } else {
            setActiveSong(0);
        }
        sound[activeSong()].play();
        localStorage.setItem('activeSong', activeSong());

        setActive();
    }

    // previous song
    const prevSong = () => {
        sound[activeSong()].stop();
        if (activeSong() > 0) {
            setActiveSong(parseInt(activeSong()) - 1);
        } else {
            setActiveSong(playerMusics.length - 1);
        }
        sound[activeSong()].play();
        localStorage.setItem('activeSong', activeSong());
        setActive();
    }

    sidebarPlayer.querySelector('#song-next').addEventListener('click', nextSong);
    sidebarPlayer.querySelector('#song-prev').addEventListener('click', prevSong);

    // play and pause
    sidebarPlayer.querySelector('#play-pause').addEventListener('click', () => {
        if (sound[activeSong()].playing()) {
            sound[activeSong()].pause();
            sidebarPlayer.classList.remove('playing');
        } else {
            sound[activeSong()].play();
            sidebarPlayer.classList.add('playing');
        }
    });

    // auto play button
    autoPlayBtn.addEventListener('click', () => {
        if (autoPlay() === 'enabled') {
            autoPlayBtn.classList.remove('enabled');
            localStorage.setItem('autoPlay', 'disabled');
            setAutoPlay('disabled');
        } else {
            autoPlayBtn.classList.add('enabled');
            localStorage.setItem('autoPlay', 'enabled');
            setAutoPlay('enabled');
        }
    });
}
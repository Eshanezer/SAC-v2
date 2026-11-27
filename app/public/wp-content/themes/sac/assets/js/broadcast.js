/**
 * Play HLS streams using native playback where available.
 */
(() => {
	'use strict';

	const player = document.querySelector('[data-sac-hls]');
	const status = document.querySelector('[data-sac-hls-status]');
	if (!player || !status) {
		return;
	}

	const reportFailure = () => {
		status.textContent = status.dataset.error;
	};

	if (player.canPlayType('application/vnd.apple.mpegurl')) {
		player.addEventListener('error', reportFailure);
		player.src = player.dataset.sacHls;
		return;
	}

	if (!window.Hls?.isSupported()) {
		reportFailure();
		return;
	}

	const hls = new window.Hls();
	hls.on(window.Hls.Events.ERROR, (_event, data) => {
		if (data.fatal) {
			hls.destroy();
			reportFailure();
		}
	});
	hls.loadSource(player.dataset.sacHls);
	hls.attachMedia(player);
})();

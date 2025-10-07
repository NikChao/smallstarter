import { getTime } from 'utils/get-time.js';

const timeEl = document.getElementById('time');
setInterval(async () => {
  const time = await getTime();
  timeEl.innerText = time;
}, 1000);

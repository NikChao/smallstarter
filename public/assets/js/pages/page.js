import { getRandomNumber } from 'utils/get-random-number.js';

const randomValue = document.getElementById('random');
document.getElementById('apiButton').addEventListener('click', async () => {
  const result = await getRandomNumber();
  randomValue.innerText = result;
})

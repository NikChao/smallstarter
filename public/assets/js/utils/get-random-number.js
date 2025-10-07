export async function getRandomNumber() {
  const res = await fetch('/api/random');
  const json = await res.json();

  return json.value;
}

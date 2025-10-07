export async function getTime() {
  const res = await fetch('/api/time');
  const json = await res.json();
  return json.time;
}

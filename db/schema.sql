create extension if not exists pgcrypto;


create or replace function uuidv7()
returns uuid as $$
declare
    millis bigint := (extract(epoch from clock_timestamp()) * 1000)::bigint;
    random_part uuid := gen_random_uuid();
begin
    return (
        lpad(to_hex(millis), 12, '0') ||
        substr(replace(random_part::text, '-', ''), 13)
    )::uuid;
end;
$$ language plpgsql immutable;

CREATE OR REPLACE FUNCTION uuid_extract_timestamp(u uuid)
RETURNS timestamptz
LANGUAGE sql
AS $$
  SELECT to_timestamp(
    ('x' || substr(encode(uuid_send(u), 'hex'), 1, 12))::bit(48)::bigint / 1000.0
  );
$$;

CREATE TABLE IF NOT EXISTS public.fun_items (
  id uuid primary key default uuidv7(),
  value text default 'fun!'
);

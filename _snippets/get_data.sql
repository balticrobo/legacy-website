-- get teams
SELECT
  t.id AS team_id,
  t.created_by_id,
  CONCAT(u.forename, ' ', u.surname) AS created_by,
  u.email AS created_by_email,
  t.identifier AS team_identifier,
  t.name AS team_name,
  t.city AS team_city,
  IFNULL(t.scientific_organization, '') AS team_scientific_organization,
  FROM_UNIXTIME(t.created_at) AS team_created_at,
  COUNT(DISTINCT c.id) AS constructions_count,
  COUNT(DISTINCT m.id) AS competitors_count
FROM registration_teams t
  JOIN users u on t.created_by_id = u.id
  JOIN registration_constructions c on t.id = c.team_id
  JOIN registration_members m on t.id = m.team_id
  JOIN events e on t.event_id = e.id
WHERE e.year = 2019
GROUP BY t.id;

-- get members
SELECT
  m.id AS member_id,
  m.team_id,
  t.name AS team_name,
  CONCAT(m.forename, ' ', m.surname) AS member_name,
  CASE m.shirt_type
    WHEN 0 THEN 'Brak'
    WHEN 30 THEN 'XS'
    WHEN 31 THEN 'S'
    WHEN 32 THEN 'M'
    WHEN 33 THEN 'L'
    WHEN 34 THEN 'XL'
    WHEN 35 THEN 'XXL'
    WHEN 36 THEN 'XXXL'
    ELSE '??? ZŁE DANE ???'
  END AS shirt_type,
  FROM_UNIXTIME(m.created_at) AS member_created_at
FROM registration_members m
  JOIN registration_teams t on m.team_id = t.id
  JOIN events e on t.event_id = e.id
WHERE e.year = 2019
ORDER BY t.id;

-- get count of constructions in each competition
SELECT
  c.name AS competition_name,
  COUNT(rcc.competition_id) AS count
FROM registration_constructions rc
  JOIN registration_constructions_competitions rcc on rc.id = rcc.construction_id
  JOIN competitions c on rcc.competition_id = c.id
  JOIN registration_teams rt on rc.team_id = rt.id
  JOIN events e on rt.event_id = e.id
WHERE e.year = 2019
GROUP BY rcc.competition_id;

-- get volunteers
SELECT
  v.id AS id,
  v.name AS name,
  v.phone_number AS phone_number,
  v.email AS email,
  CASE v.shirt_type
    WHEN 0 THEN 'Brak'
    WHEN 30 THEN 'XS'
    WHEN 31 THEN 'S'
    WHEN 32 THEN 'M'
    WHEN 33 THEN 'L'
    WHEN 34 THEN 'XL'
    WHEN 35 THEN 'XXL'
    WHEN 36 THEN 'XXXL'
    ELSE '??? ZŁE DANE ???'
    END AS shirt_type,
  FROM_UNIXTIME(v.created_at) AS created_at
FROM volunteers v
  JOIN events e on v.event_id = e.id
WHERE e.year = 2019;

-- OLD !!! 2018 !!! OLD
-- get names of members to print identifiers and other stuff
SELECT t1.*
FROM (
  SELECT
    CONCAT(m.forename, ' ', m.surname) AS name,
    t.name AS team_name,
    t.identifier AS team_identifier,
    'competition' AS type
  FROM registration_members m
    JOIN registration_teams t on m.team_id = t.id
  ORDER BY t.id) t1
UNION
SELECT t2.*
FROM (
  SELECT
    CONCAT(m.forename, ' ', m.surname) AS name,
    t.name AS team_name,
    '' AS team_identifier,
    'hackathon' AS type
  FROM registration_members_hackathon m
    JOIN registration_teams_hackathon t on m.team_id = t.id
  ORDER BY t.id
) t2;


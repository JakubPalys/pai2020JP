BEGIN;

CREATE TABLE IF NOT EXISTS public.bet_results
(
    result_id serial NOT NULL,
    result_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT bet_results_pkey PRIMARY KEY (result_id)
);

CREATE TABLE IF NOT EXISTS public.bets
(
    bet_id serial NOT NULL,
    user_id integer,
    event_id integer,
    bet_amount integer NOT NULL,
    bet_choice character varying(50) COLLATE pg_catalog."default" NOT NULL,
    bet_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    potential_win numeric(10, 2) NOT NULL DEFAULT 0.00,
    CONSTRAINT bets_pkey PRIMARY KEY (bet_id)
);

CREATE TABLE IF NOT EXISTS public.event_results
(
    event_id integer NOT NULL,
    result_id integer,
    CONSTRAINT event_results_pkey PRIMARY KEY (event_id)
);

CREATE TABLE IF NOT EXISTS public.event_statuses
(
    status_id serial NOT NULL,
    status_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT event_statuses_pkey PRIMARY KEY (status_id)
);

CREATE TABLE IF NOT EXISTS public.events
(
    event_id serial NOT NULL,
    event_name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    event_date timestamp without time zone NOT NULL,
    status_id integer,
    home_odds numeric(5, 2) NOT NULL DEFAULT 1.0,
    away_odds numeric(5, 2) NOT NULL DEFAULT 1.0,
    draw_odds numeric(5, 2) NOT NULL DEFAULT 1.0,
    CONSTRAINT events_pkey PRIMARY KEY (event_id)
);

CREATE TABLE IF NOT EXISTS public.user_bet_results
(
    bet_id integer NOT NULL,
    result_id integer,
    points_awarded integer DEFAULT 0,
    CONSTRAINT user_bet_results_pkey PRIMARY KEY (bet_id)
);

CREATE TABLE IF NOT EXISTS public.user_roles
(
    role_id serial NOT NULL,
    role_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT user_roles_pkey PRIMARY KEY (role_id)
);

CREATE TABLE IF NOT EXISTS public.users
(
    user_id serial NOT NULL,
    username character varying(50) COLLATE pg_catalog."default" NOT NULL,
    email character varying(100) COLLATE pg_catalog."default" NOT NULL,
    password_hash character varying(255) COLLATE pg_catalog."default" NOT NULL,
    role_id integer,
    points integer DEFAULT 0,
    CONSTRAINT users_pkey PRIMARY KEY (user_id),
    CONSTRAINT users_email_key UNIQUE (email),
    CONSTRAINT users_username_key UNIQUE (username)
);

ALTER TABLE IF EXISTS public.bets
    ADD CONSTRAINT bets_event_id_fkey FOREIGN KEY (event_id)
    REFERENCES public.events (event_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.bets
    ADD CONSTRAINT bets_user_id_fkey FOREIGN KEY (user_id)
    REFERENCES public.users (user_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.event_results
    ADD CONSTRAINT event_results_event_id_fkey FOREIGN KEY (event_id)
    REFERENCES public.events (event_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX IF NOT EXISTS event_results_pkey
    ON public.event_results(event_id);


ALTER TABLE IF EXISTS public.event_results
    ADD CONSTRAINT event_results_result_id_fkey FOREIGN KEY (result_id)
    REFERENCES public.bet_results (result_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.events
    ADD CONSTRAINT events_status_id_fkey FOREIGN KEY (status_id)
    REFERENCES public.event_statuses (status_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.user_bet_results
    ADD CONSTRAINT user_bet_results_bet_id_fkey FOREIGN KEY (bet_id)
    REFERENCES public.bets (bet_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX IF NOT EXISTS user_bet_results_pkey
    ON public.user_bet_results(bet_id);


ALTER TABLE IF EXISTS public.user_bet_results
    ADD CONSTRAINT user_bet_results_result_id_fkey FOREIGN KEY (result_id)
    REFERENCES public.bet_results (result_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.users
    ADD CONSTRAINT users_role_id_fkey FOREIGN KEY (role_id)
    REFERENCES public.user_roles (role_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;

-- Insert roles
INSERT INTO user_roles (role_name)
VALUES ('user'), ('admin');

-- Insert event statuses
INSERT INTO event_statuses (status_name)
VALUES ('pending'), ('finished');

-- Insert bet results
INSERT INTO bet_results (result_name)
VALUES ('win'), ('lose'), ('draw');

INSERT INTO public.bets (bet_id, user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) VALUES (21, 16, 13, 50, 'home', '2025-02-14 14:00:00.000000', 0.00);
INSERT INTO public.bets (bet_id, user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) VALUES (22, 17, 13, 100, 'away', '2025-02-14 15:00:00.000000', 0.00);
INSERT INTO public.bets (bet_id, user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) VALUES (23, 18, 14, 150, 'draw', '2025-02-14 16:00:00.000000', 0.00);
INSERT INTO public.bets (bet_id, user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) VALUES (24, 16, 15, 75, 'home', '2025-02-14 17:00:00.000000', 0.00);
INSERT INTO public.bets (bet_id, user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) VALUES (27, 22, 13, 200, 'home', '2025-02-12 21:18:33.309694', 200.00);
INSERT INTO public.bets (bet_id, user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) VALUES (28, 22, 14, 300, 'home', '2025-02-12 23:37:59.861053', 300.00);
INSERT INTO public.bets (bet_id, user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) VALUES (29, 22, 14, 300, 'home', '2025-02-12 23:39:19.632018', 300.00);
INSERT INTO public.bets (bet_id, user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) VALUES (30, 22, 14, 100, 'home', '2025-02-12 23:42:11.865812', 100.00);
INSERT INTO public.bets (bet_id, user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) VALUES (31, 22, 14, 100, 'home', '2025-02-12 23:43:15.656024', 100.00);

INSERT INTO public.event_results (event_id, result_id) VALUES (15, 1);

INSERT INTO public.events (event_id, event_name, event_date, status_id, home_odds, away_odds, draw_odds) VALUES (13, 'Mecz A vs B', '2025-02-15 20:00:00.000000', 1, 1.00, 1.00, 1.00);
INSERT INTO public.events (event_id, event_name, event_date, status_id, home_odds, away_odds, draw_odds) VALUES (14, 'Mecz C vs D', '2025-02-16 18:00:00.000000', 1, 1.00, 1.00, 1.00);
INSERT INTO public.events (event_id, event_name, event_date, status_id, home_odds, away_odds, draw_odds) VALUES (15, 'Mecz E vs F', '2025-02-17 20:00:00.000000', 2, 1.00, 1.00, 1.00);
INSERT INTO public.events (event_id, event_name, event_date, status_id, home_odds, away_odds, draw_odds) VALUES (18, 'Mecz G vs H', '2025-02-14 04:33:00.000000', 1, 2.00, 3.00, 2.00);

INSERT INTO public.user_bet_results (bet_id, result_id, points_awarded) VALUES (21, 2, 0);
INSERT INTO public.user_bet_results (bet_id, result_id, points_awarded) VALUES (22, 1, 10);
INSERT INTO public.user_bet_results (bet_id, result_id, points_awarded) VALUES (23, 2, 0);

INSERT INTO public.users (user_id, username, email, password_hash, role_id, points) VALUES (2, 'a', 'a@gmail.com', '$2y$10$LVau/h7ADtJhMKysjy8BB.NSNxZOTsFDMHlglEpryDvRCVlwyMQzC', 1, 0);
INSERT INTO public.users (user_id, username, email, password_hash, role_id, points) VALUES (3, 'Abba', 'Abba@gmail.com', '$2y$10$ZFPcdVRjpQg4i46La6CGTeAZJX2ocoPkjEaKi580YUHx02F9SWy8i', 1, 0);
INSERT INTO public.users (user_id, username, email, password_hash, role_id, points) VALUES (16, 'john_doe', 'john.doe@example.com', '$2y$10$LVau/h7ADtJhMKysjy8BB.NSNxZOTsFDMHlglEpryDvRCVlwyMQzC1', 1, 120);
INSERT INTO public.users (user_id, username, email, password_hash, role_id, points) VALUES (17, 'jane_smith', 'jane.smith@example.com', '$2y$10$LVau/h7ADtJhMKysjy8BB.NSNxZOTsFDMHlglEpryDvRCVlwyMQzC1', 1, 150);
INSERT INTO public.users (user_id, username, email, password_hash, role_id, points) VALUES (18, 'alex_brown', 'alex.brown@example.com', '$2y$10$LVau/h7ADtJhMKysjy8BB.NSNxZOTsFDMHlglEpryDvRCVlwyMQzC1', 1, 200);
INSERT INTO public.users (user_id, username, email, password_hash, role_id, points) VALUES (19, 'admin', 'admin@example.com', '$2y$10$ZFPcdVRjpQg4i46La6CGTeAZJX2ocoPkjEaKi580YUHx02F9SWy8i', 2, 0);
INSERT INTO public.users (user_id, username, email, password_hash, role_id, points) VALUES (20, 'user', 'user@gmail.com', '$2y$10$tGSZEuizmlrl6FzZDdmEYeGDox2pPQi7/u3luYkf.8qd8eEQMzh5m', 1, 1000);
INSERT INTO public.users (user_id, username, email, password_hash, role_id, points) VALUES (22, 'uuu', 'uuu@gmail.com', '$2y$10$8YqJN2wlqsHhFQxV6SSg/OeMBZ1Ip/QILWuzPuVzLgecTm/DD3sLi', 1, 0);

END;

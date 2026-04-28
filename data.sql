--
-- PostgreSQL database dump
--

\restrict LanwTwHsL078nmhGFxrwcKwzenH2G39GgOKl3yXddJ5hXpJQ4D4QoRKIfepmiRA

-- Dumped from database version 16.13
-- Dumped by pg_dump version 17.6

-- Started on 2026-04-18 19:58:28

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 216 (class 1259 OID 16407)
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id integer NOT NULL,
    nom character varying(100) NOT NULL
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16406)
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO postgres;

--
-- TOC entry 4955 (class 0 OID 0)
-- Dependencies: 215
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- TOC entry 220 (class 1259 OID 16428)
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    id integer NOT NULL,
    nom character varying(100) NOT NULL,
    email character varying(150) NOT NULL,
    adresse text,
    telephone character varying(20)
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16427)
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clients_id_seq OWNER TO postgres;

--
-- TOC entry 4956 (class 0 OID 0)
-- Dependencies: 219
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;


--
-- TOC entry 228 (class 1259 OID 16476)
-- Name: coffret_parfums; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.coffret_parfums (
    id integer NOT NULL,
    coffret_id integer,
    parfum_id integer
);


ALTER TABLE public.coffret_parfums OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 16475)
-- Name: coffret_parfums_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.coffret_parfums_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.coffret_parfums_id_seq OWNER TO postgres;

--
-- TOC entry 4957 (class 0 OID 0)
-- Dependencies: 227
-- Name: coffret_parfums_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.coffret_parfums_id_seq OWNED BY public.coffret_parfums.id;


--
-- TOC entry 226 (class 1259 OID 16467)
-- Name: coffrets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.coffrets (
    id integer NOT NULL,
    nom text NOT NULL,
    prix numeric(10,2) NOT NULL,
    image text
);


ALTER TABLE public.coffrets OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16466)
-- Name: coffrets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.coffrets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.coffrets_id_seq OWNER TO postgres;

--
-- TOC entry 4958 (class 0 OID 0)
-- Dependencies: 225
-- Name: coffrets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.coffrets_id_seq OWNED BY public.coffrets.id;


--
-- TOC entry 222 (class 1259 OID 16437)
-- Name: commandes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.commandes (
    id integer NOT NULL,
    date_commande timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    total numeric(10,2),
    client_id integer
);


ALTER TABLE public.commandes OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16436)
-- Name: commandes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.commandes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.commandes_id_seq OWNER TO postgres;

--
-- TOC entry 4959 (class 0 OID 0)
-- Dependencies: 221
-- Name: commandes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.commandes_id_seq OWNED BY public.commandes.id;


--
-- TOC entry 224 (class 1259 OID 16450)
-- Name: details_commande; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.details_commande (
    id integer NOT NULL,
    commande_id integer,
    parfum_id integer,
    quantite integer
);


ALTER TABLE public.details_commande OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16449)
-- Name: details_commande_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.details_commande_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.details_commande_id_seq OWNER TO postgres;

--
-- TOC entry 4960 (class 0 OID 0)
-- Dependencies: 223
-- Name: details_commande_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.details_commande_id_seq OWNED BY public.details_commande.id;


--
-- TOC entry 218 (class 1259 OID 16414)
-- Name: parfums; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parfums (
    id integer NOT NULL,
    nom text NOT NULL,
    marque text NOT NULL,
    prix numeric(10,2) NOT NULL,
    image text,
    categorie_id integer,
    volume integer,
    prix50 numeric,
    prix80 numeric,
    prix100 numeric
);


ALTER TABLE public.parfums OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16413)
-- Name: parfums_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.parfums_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.parfums_id_seq OWNER TO postgres;

--
-- TOC entry 4961 (class 0 OID 0)
-- Dependencies: 217
-- Name: parfums_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.parfums_id_seq OWNED BY public.parfums.id;


--
-- TOC entry 4765 (class 2604 OID 16410)
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- TOC entry 4767 (class 2604 OID 16431)
-- Name: clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);


--
-- TOC entry 4772 (class 2604 OID 16479)
-- Name: coffret_parfums id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coffret_parfums ALTER COLUMN id SET DEFAULT nextval('public.coffret_parfums_id_seq'::regclass);


--
-- TOC entry 4771 (class 2604 OID 16470)
-- Name: coffrets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coffrets ALTER COLUMN id SET DEFAULT nextval('public.coffrets_id_seq'::regclass);


--
-- TOC entry 4768 (class 2604 OID 16440)
-- Name: commandes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes ALTER COLUMN id SET DEFAULT nextval('public.commandes_id_seq'::regclass);


--
-- TOC entry 4770 (class 2604 OID 16453)
-- Name: details_commande id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.details_commande ALTER COLUMN id SET DEFAULT nextval('public.details_commande_id_seq'::regclass);


--
-- TOC entry 4766 (class 2604 OID 16417)
-- Name: parfums id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parfums ALTER COLUMN id SET DEFAULT nextval('public.parfums_id_seq'::regclass);


--
-- TOC entry 4937 (class 0 OID 16407)
-- Dependencies: 216
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, nom) FROM stdin;
1	Homme
2	Femme
3	Mixte
\.


--
-- TOC entry 4941 (class 0 OID 16428)
-- Dependencies: 220
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clients (id, nom, email, adresse, telephone) FROM stdin;
\.


--
-- TOC entry 4949 (class 0 OID 16476)
-- Dependencies: 228
-- Data for Name: coffret_parfums; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.coffret_parfums (id, coffret_id, parfum_id) FROM stdin;
\.


--
-- TOC entry 4947 (class 0 OID 16467)
-- Dependencies: 226
-- Data for Name: coffrets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.coffrets (id, nom, prix, image) FROM stdin;
1	Coffret Ameerat Al Arab	35.00	image/amiretarab.jpg
3	Coffret Libre YSL	45.00	image/yves-saint-laurent-coffret-eau-de-parfum-libre-50ml.webp
4	Coffret Y Men YSL	45.00	image/coffret-eau-de-parfum-homme-yves-saint-laurent-y-men-coffrets.webp
\.


--
-- TOC entry 4943 (class 0 OID 16437)
-- Dependencies: 222
-- Data for Name: commandes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.commandes (id, date_commande, total, client_id) FROM stdin;
\.


--
-- TOC entry 4945 (class 0 OID 16450)
-- Dependencies: 224
-- Data for Name: details_commande; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.details_commande (id, commande_id, parfum_id, quantite) FROM stdin;
\.


--
-- TOC entry 4939 (class 0 OID 16414)
-- Dependencies: 218
-- Data for Name: parfums; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.parfums (id, nom, marque, prix, image, categorie_id, volume, prix50, prix80, prix100) FROM stdin;
1	Bleu de Chanel	Chanel	80.00	image/bleudechanel.jpeg	1	100	25	45	80
2	Boss Bottled	Hugo Boss	80.00	image/boss.jpeg	1	100	25	45	80
3	Sauvage	Dior	80.00	image/sauvage.jpeg	1	100	25	45	80
4	The One	Dolce & Gabbana	80.00	image/the-one-for-men.jpg	1	100	25	45	80
5	Y	Yves Saint Laurent	80.00	image/y.jpeg	1	60	25	45	80
6	Good Girl	Carolina Herrera	25.00	image/goodgirl.jpeg	2	50	25	45	80
7	Miss Dior	Dior	25.00	image/dior-jpeg.webp	2	50	25	45	80
8	L Evidence	Yves Rocher	25.00	image/evidence.jpg	2	50	25	45	80
9	Scandal	Jean Paul Gaultier	80.00	image/jean-paul-gaultier-scandaljpeg.webp	2	80	25	45	80
10	Libre	Yves Saint Laurent	80.00	image/libre.jpg	2	90	25	45	80
11	Yara	Lattafa	80.00	image/yara.jpeg	2	100	25	45	80
12	Kayali Yum	Kayali	80.00	image/Kayali-Yum-Boujee-Marshmallow.jpeg	2	100	25	45	80
13	Harem	Arvea	25.00	image/harim.jpeg	2	50	25	45	80
14	Zara Nuit	Zara	80.00	image/zara.jpg	2	80	25	45	80
15	Ameerat Al Arab	Asdaaf	80.00	image/ameerat-el-arab.jpeg	2	100	25	45	80
\.


--
-- TOC entry 4962 (class 0 OID 0)
-- Dependencies: 215
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 3, true);


--
-- TOC entry 4963 (class 0 OID 0)
-- Dependencies: 219
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_id_seq', 1, false);


--
-- TOC entry 4964 (class 0 OID 0)
-- Dependencies: 227
-- Name: coffret_parfums_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.coffret_parfums_id_seq', 1, false);


--
-- TOC entry 4965 (class 0 OID 0)
-- Dependencies: 225
-- Name: coffrets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.coffrets_id_seq', 4, true);


--
-- TOC entry 4966 (class 0 OID 0)
-- Dependencies: 221
-- Name: commandes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.commandes_id_seq', 1, false);


--
-- TOC entry 4967 (class 0 OID 0)
-- Dependencies: 223
-- Name: details_commande_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.details_commande_id_seq', 1, false);


--
-- TOC entry 4968 (class 0 OID 0)
-- Dependencies: 217
-- Name: parfums_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.parfums_id_seq', 15, true);


--
-- TOC entry 4774 (class 2606 OID 16412)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- TOC entry 4778 (class 2606 OID 16435)
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- TOC entry 4786 (class 2606 OID 16481)
-- Name: coffret_parfums coffret_parfums_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coffret_parfums
    ADD CONSTRAINT coffret_parfums_pkey PRIMARY KEY (id);


--
-- TOC entry 4784 (class 2606 OID 16474)
-- Name: coffrets coffrets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coffrets
    ADD CONSTRAINT coffrets_pkey PRIMARY KEY (id);


--
-- TOC entry 4780 (class 2606 OID 16443)
-- Name: commandes commandes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes
    ADD CONSTRAINT commandes_pkey PRIMARY KEY (id);


--
-- TOC entry 4782 (class 2606 OID 16455)
-- Name: details_commande details_commande_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.details_commande
    ADD CONSTRAINT details_commande_pkey PRIMARY KEY (id);


--
-- TOC entry 4776 (class 2606 OID 16421)
-- Name: parfums parfums_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parfums
    ADD CONSTRAINT parfums_pkey PRIMARY KEY (id);


--
-- TOC entry 4791 (class 2606 OID 16482)
-- Name: coffret_parfums coffret_parfums_coffret_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coffret_parfums
    ADD CONSTRAINT coffret_parfums_coffret_id_fkey FOREIGN KEY (coffret_id) REFERENCES public.coffrets(id);


--
-- TOC entry 4792 (class 2606 OID 16487)
-- Name: coffret_parfums coffret_parfums_parfum_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coffret_parfums
    ADD CONSTRAINT coffret_parfums_parfum_id_fkey FOREIGN KEY (parfum_id) REFERENCES public.parfums(id);


--
-- TOC entry 4788 (class 2606 OID 16444)
-- Name: commandes commandes_client_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes
    ADD CONSTRAINT commandes_client_id_fkey FOREIGN KEY (client_id) REFERENCES public.clients(id);


--
-- TOC entry 4789 (class 2606 OID 16456)
-- Name: details_commande details_commande_commande_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.details_commande
    ADD CONSTRAINT details_commande_commande_id_fkey FOREIGN KEY (commande_id) REFERENCES public.commandes(id);


--
-- TOC entry 4790 (class 2606 OID 16461)
-- Name: details_commande details_commande_parfum_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.details_commande
    ADD CONSTRAINT details_commande_parfum_id_fkey FOREIGN KEY (parfum_id) REFERENCES public.parfums(id);


--
-- TOC entry 4787 (class 2606 OID 16422)
-- Name: parfums parfums_categorie_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parfums
    ADD CONSTRAINT parfums_categorie_id_fkey FOREIGN KEY (categorie_id) REFERENCES public.categories(id);


-- Completed on 2026-04-18 19:58:28

--
-- PostgreSQL database dump complete
--

\unrestrict LanwTwHsL078nmhGFxrwcKwzenH2G39GgOKl3yXddJ5hXpJQ4D4QoRKIfepmiRA


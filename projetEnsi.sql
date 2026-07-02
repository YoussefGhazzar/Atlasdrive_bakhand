--
-- PostgreSQL database dump
--

-- Dumped from database version 16.9
-- Dumped by pg_dump version 16.9

-- Started on 2026-07-02 09:38:07

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
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
-- TOC entry 234 (class 1259 OID 32743)
-- Name: admins; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admins (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.admins OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 32742)
-- Name: admins_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.admins_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.admins_id_seq OWNER TO postgres;

--
-- TOC entry 5076 (class 0 OID 0)
-- Dependencies: 233
-- Name: admins_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.admins_id_seq OWNED BY public.admins.id;


--
-- TOC entry 238 (class 1259 OID 32761)
-- Name: agences; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.agences (
    id bigint NOT NULL,
    nom character varying(255),
    prenom character varying(255),
    address character varying(255),
    telephone character varying(255),
    email character varying(255),
    password character varying(255),
    confirm_password character varying(255),
    nom_agence character varying(255),
    ville character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    user_id bigint,
    status character varying(255) DEFAULT 'Pending'::character varying NOT NULL,
    CONSTRAINT agences_status_check CHECK (((status)::text = ANY ((ARRAY['Pending'::character varying, 'Verified'::character varying, 'Suspended'::character varying])::text[])))
);


ALTER TABLE public.agences OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 32760)
-- Name: agences_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.agences_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.agences_id_seq OWNER TO postgres;

--
-- TOC entry 5077 (class 0 OID 0)
-- Dependencies: 237
-- Name: agences_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.agences_id_seq OWNED BY public.agences.id;


--
-- TOC entry 219 (class 1259 OID 32638)
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 32646)
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- TOC entry 246 (class 1259 OID 32909)
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    icon character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 32908)
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO postgres;

--
-- TOC entry 5078 (class 0 OID 0)
-- Dependencies: 245
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- TOC entry 236 (class 1259 OID 32750)
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    id bigint NOT NULL,
    nom character varying(255),
    prenom character varying(255),
    user_id bigint,
    email character varying(255),
    password character varying(255),
    confirm_password character varying(255),
    telephone character varying(255),
    ville character varying(255),
    address character varying(255),
    numero_permis character varying(255),
    date_expiration_permis date,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 32749)
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clients_id_seq OWNER TO postgres;

--
-- TOC entry 5079 (class 0 OID 0)
-- Dependencies: 235
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;


--
-- TOC entry 225 (class 1259 OID 32672)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 32671)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5080 (class 0 OID 0)
-- Dependencies: 224
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 223 (class 1259 OID 32664)
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 32655)
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 32654)
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5081 (class 0 OID 0)
-- Dependencies: 221
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- TOC entry 216 (class 1259 OID 32621)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 32620)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 5082 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 230 (class 1259 OID 32705)
-- Name: model_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_permissions OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 32716)
-- Name: model_has_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_roles OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 32800)
-- Name: payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payments (
    id bigint NOT NULL,
    agence_id bigint NOT NULL,
    user_id bigint NOT NULL,
    plan character varying(255) NOT NULL,
    billing_cycle character varying(255) NOT NULL,
    amount numeric(8,2) NOT NULL,
    cardholder_name character varying(255) NOT NULL,
    address character varying(255) NOT NULL,
    city character varying(255) NOT NULL,
    postal_code character varying(255) NOT NULL,
    status character varying(255) DEFAULT 'completed'::character varying NOT NULL,
    transaction_id character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.payments OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 32799)
-- Name: payments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.payments_id_seq OWNER TO postgres;

--
-- TOC entry 5083 (class 0 OID 0)
-- Dependencies: 243
-- Name: payments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payments_id_seq OWNED BY public.payments.id;


--
-- TOC entry 227 (class 1259 OID 32684)
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 32683)
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permissions_id_seq OWNER TO postgres;

--
-- TOC entry 5084 (class 0 OID 0)
-- Dependencies: 226
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- TOC entry 242 (class 1259 OID 32786)
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name text NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 32785)
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 5085 (class 0 OID 0)
-- Dependencies: 241
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- TOC entry 250 (class 1259 OID 32966)
-- Name: reservations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reservations (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    voiture_id bigint NOT NULL,
    agency_id bigint NOT NULL,
    date_debut date NOT NULL,
    date_fin date NOT NULL,
    prix_total numeric(10,2) DEFAULT '0'::numeric NOT NULL,
    statut character varying(255) DEFAULT 'en_attente'::character varying NOT NULL,
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.reservations OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 32965)
-- Name: reservations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reservations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reservations_id_seq OWNER TO postgres;

--
-- TOC entry 5086 (class 0 OID 0)
-- Dependencies: 249
-- Name: reservations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.reservations_id_seq OWNED BY public.reservations.id;


--
-- TOC entry 232 (class 1259 OID 32727)
-- Name: role_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


ALTER TABLE public.role_has_permissions OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 32695)
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 32694)
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO postgres;

--
-- TOC entry 5087 (class 0 OID 0)
-- Dependencies: 228
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- TOC entry 251 (class 1259 OID 32991)
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 32770)
-- Name: table_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.table_roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.table_roles OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 32769)
-- Name: table_roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.table_roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.table_roles_id_seq OWNER TO postgres;

--
-- TOC entry 5088 (class 0 OID 0)
-- Dependencies: 239
-- Name: table_roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.table_roles_id_seq OWNED BY public.table_roles.id;


--
-- TOC entry 218 (class 1259 OID 32628)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    nom character varying(255) NOT NULL,
    prenom character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    telephone character varying(255),
    address character varying(255),
    ville character varying(255),
    password character varying(255),
    confirm_password character varying(255),
    email_verified_at timestamp(0) without time zone,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 32627)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 5089 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 248 (class 1259 OID 32920)
-- Name: voitures; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.voitures (
    id bigint NOT NULL,
    agency_id bigint NOT NULL,
    category_id bigint NOT NULL,
    marque character varying(255) NOT NULL,
    modele character varying(255) NOT NULL,
    annee smallint NOT NULL,
    immatriculation character varying(255) NOT NULL,
    prix_par_jour numeric(8,2) NOT NULL,
    nb_places integer DEFAULT 5 NOT NULL,
    transmission character varying(255) DEFAULT 'manuelle'::character varying NOT NULL,
    carburant character varying(255) DEFAULT 'essence'::character varying NOT NULL,
    couleur character varying(255),
    image character varying(255),
    disponible boolean DEFAULT true NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.voitures OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 32919)
-- Name: voitures_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.voitures_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.voitures_id_seq OWNER TO postgres;

--
-- TOC entry 5090 (class 0 OID 0)
-- Dependencies: 247
-- Name: voitures_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.voitures_id_seq OWNED BY public.voitures.id;


--
-- TOC entry 4793 (class 2604 OID 32746)
-- Name: admins id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins ALTER COLUMN id SET DEFAULT nextval('public.admins_id_seq'::regclass);


--
-- TOC entry 4795 (class 2604 OID 32764)
-- Name: agences id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agences ALTER COLUMN id SET DEFAULT nextval('public.agences_id_seq'::regclass);


--
-- TOC entry 4801 (class 2604 OID 32912)
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- TOC entry 4794 (class 2604 OID 32753)
-- Name: clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);


--
-- TOC entry 4789 (class 2604 OID 32675)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 4788 (class 2604 OID 32658)
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- TOC entry 4786 (class 2604 OID 32624)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4799 (class 2604 OID 32803)
-- Name: payments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments ALTER COLUMN id SET DEFAULT nextval('public.payments_id_seq'::regclass);


--
-- TOC entry 4791 (class 2604 OID 32687)
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- TOC entry 4798 (class 2604 OID 32789)
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- TOC entry 4807 (class 2604 OID 32969)
-- Name: reservations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations ALTER COLUMN id SET DEFAULT nextval('public.reservations_id_seq'::regclass);


--
-- TOC entry 4792 (class 2604 OID 32698)
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- TOC entry 4797 (class 2604 OID 32773)
-- Name: table_roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_roles ALTER COLUMN id SET DEFAULT nextval('public.table_roles_id_seq'::regclass);


--
-- TOC entry 4787 (class 2604 OID 32631)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 4802 (class 2604 OID 32923)
-- Name: voitures id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.voitures ALTER COLUMN id SET DEFAULT nextval('public.voitures_id_seq'::regclass);


--
-- TOC entry 5053 (class 0 OID 32743)
-- Dependencies: 234
-- Data for Name: admins; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admins (id, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5057 (class 0 OID 32761)
-- Dependencies: 238
-- Data for Name: agences; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.agences (id, nom, prenom, address, telephone, email, password, confirm_password, nom_agence, ville, created_at, updated_at, user_id, status) FROM stdin;
1	youssef	ghazzar	Mesnana,Tanger	0713524393	youssef25@agence.com	\N	\N	Mon Agence Immobiliere	Tanger	2026-05-07 16:06:29	2026-05-07 16:06:29	5	Pending
2	ghazzar	soulaiman	Poussgeur,Tanger	+212785471236	soulaiman@gmail.com	\N	\N	Ghazzar agency	Tanger	2026-05-08 00:01:05	2026-05-08 00:01:05	9	Pending
3	benmoumn	adil	TETOUAN,bb	+21278965412	adil@gmail.com	\N	\N	adil agency	Tétouan	2026-05-08 21:58:35	2026-05-08 21:58:35	11	Pending
4	dddd	dwww	Tanger	+21278965241	youssefghazzar15@gmail.com	\N	\N	wddd	Tétouan	2026-05-08 22:22:50	2026-05-08 22:22:50	12	Pending
5	bbb	bbbb	laayoun	+21268547925	youssefghazzar20@gmail.com	\N	\N	bbbbbb	Laâyoune	2026-05-08 22:27:45	2026-05-08 22:27:45	13	Pending
6	ddddd	dddddd	merakeh	+21258444448	youssefghazzar25@gmail.com	\N	\N	ccccccccc	Marrakech	2026-05-08 22:35:12	2026-05-08 22:35:12	14	Pending
7	ffffff	ffffffffff	oujda,bb	+21278965412	youssefghazzar35@gmail.com	\N	\N	fffffffffffffffffff	Oujda	2026-05-08 22:39:48	2026-05-08 22:39:48	15	Pending
8	ffffffffffff	ffffffffffffffffffffff	ggggggggggggggg	+212651616165	youssefghazzar45@gmail.com	\N	\N	ffffffffffffffffffffffffffffff	Kenitra	2026-05-08 22:57:47	2026-05-08 22:57:47	16	Pending
9	ddddddddddddddddddd	dddddddddddddddddddddd	youssefghazzar15@gmail.com	+212687453214	youssefghazzar55@gmail.com	\N	\N	ddddddddddddddddddddd	Fès	2026-05-09 12:18:12	2026-05-09 12:18:12	17	Pending
10	ddddddddddddddd	ssssssssssssss	casa,bensouri	+2124884441	youssefghazzar65@gmail.com	\N	\N	ssssssssssss	Casablanca	2026-05-10 00:29:09	2026-05-10 00:29:09	18	Pending
11	cccccc	ccccccccc	jkkkk	+212648148584	youssefghazzar85@gmail.com	\N	\N	cccccccccccc	Rabat	2026-05-10 00:34:27	2026-05-10 00:34:27	19	Pending
12	ggggggggggg	ggggggggggggggggg	ggggggggggggggggg	+212752148561	youssefghazzar@gmail.com	\N	\N	gggggggggggggggggggg	Tanger	2026-05-11 00:25:46	2026-05-11 00:25:46	20	Pending
13	ddddddddddddddddd	ddddddddddddddddd	fffffffffffffffffff	+2125555558	dddd@gmail.com	\N	\N	dddddddddddddddddddddd	Agadir	2026-05-11 23:50:51	2026-05-11 23:50:51	21	Pending
14	ggggggggggggggggg	gggggggggggggggg	ggggggggggggg	+21275848935	ggggggggggggg@gmail.com	\N	\N	gggggggggggggggggg	El Jadida	2026-05-12 00:13:26	2026-05-12 00:13:26	22	Pending
15	hhgh	urfiu	hhcjcvhjvc	+212545694695	youssefghazza222r@gmail.com	\N	\N	cjkbbjc	Meknès	2026-05-13 23:51:32	2026-05-13 23:51:32	23	Pending
16	ddddddddddd	ddddddddddddddd	ggggggggggggggggg	+21244554548	youssefghazzar95@gmail.com	\N	\N	deed	Rabat	2026-05-14 00:19:31	2026-05-14 00:19:31	24	Pending
17	hiuhfr	frvfevvr	merakeh	+212541485485	youssefghazzzar123@gmail.com	\N	\N	ervcrwc	Marrakech	2026-05-14 00:23:07	2026-05-14 00:23:07	25	Pending
18	larmiche	safouan	Gezenaya Tanger	+21278965412	safouan@gmail.com	\N	\N	Imbadi	Tanger	2026-05-18 00:15:49	2026-05-18 00:15:49	33	Pending
19	larmiche	safouan	TANGER , GEZENAYA	+21278965412	safouan2@gmail.com	\N	\N	IMBADE	Tanger	2026-05-18 00:21:43	2026-05-18 00:21:43	34	Pending
20	larmiche	safouan	TANGER,GEZENAYA	+21276985412	safouan3@gmail.com	\N	\N	AMDIP	Tanger	2026-05-18 11:19:08	2026-05-18 11:19:08	35	Pending
21	ghali	saad	Tanger Mesnana	+2127896541	fastdrive@gmail.com	\N	\N	Drive fast	Tanger	2026-05-21 10:59:18	2026-05-21 10:59:18	36	Pending
22	ghali	anas	Tnanger	07848454	ghali55@gmail.com	\N	\N	vvvv	Tanger	2026-05-22 13:47:08	2026-05-22 13:47:08	37	Pending
\.


--
-- TOC entry 5038 (class 0 OID 32638)
-- Dependencies: 219
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- TOC entry 5039 (class 0 OID 32646)
-- Dependencies: 220
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- TOC entry 5065 (class 0 OID 32909)
-- Dependencies: 246
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, name, slug, description, icon, created_at, updated_at) FROM stdin;
1	Family 	family-cars	Spacious, safe, and comfortable vehicles designed to handle daily commutes, school runs, and road trips with maximum passenger and cargo space.	storage/images/Family.png	2026-06-03 23:23:39	2026-06-03 23:23:39
2	Electric 	electric-vehicles	Eco-friendly, 100% electric and hybrid cars featuring zero emissions, instant torque, and cutting-edge charging technology for a sustainable future.	storage/images/Electric.png	2026-06-03 23:23:39	2026-06-03 23:23:39
3	Economy 	economy-cars	Budget-friendly, fuel-efficient, and reliable vehicles with low maintenance costs, perfect for city driving and daily commuting.	storage/images/Economy.png	2026-06-03 23:23:39	2026-06-03 23:23:39
4	Luxury 	luxury-cars	Premium vehicles offering uncompromised comfort, high-end materials, sophisticated technology, and elite performance.	storage/images/Luxury.png	2026-06-03 23:23:39	2026-06-03 23:23:39
5	SUVs	suvs	Versatile Sports Utility Vehicles combining robust off-road capability, elevated driving positions, and generous cabin room for any adventure.	storage/images/SUV.png	2026-06-03 23:23:39	2026-06-03 23:23:39
\.


--
-- TOC entry 5055 (class 0 OID 32750)
-- Dependencies: 236
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clients (id, nom, prenom, user_id, email, password, confirm_password, telephone, ville, address, numero_permis, date_expiration_permis, created_at, updated_at) FROM stdin;
1	saad	ghali	\N	saad2006@test.com	$2y$12$1YP9mnp.XfSSSPp7dUuulOBG59195sO80tydzOrmNRn7zwQ1nYgo2	$2y$12$H/5d64XyYO536w.16UVuTOf17Fyw4RtmyI.P/bm9fy9m.362yyVQ.	0611111111	Tanger	Mesnana,Tanger	11/55455	2023-02-15	2026-05-07 16:06:46	2026-05-07 16:06:46
2	Ben ayad	karim	\N	karim25@gmail.com	$2y$12$JOJqBUpZWMJ2sqeHC3oPkubh2Rr/1MjZ.hIxV9JRoRl0/HxkfjshW	$2y$12$EurQYMSI5r3.eB4bfyPqQOeNZlmKzW24XPbWh5laLrA.ASXkpGozq	+2127896317895	Rabat	SOUANI.TANGER	11/8569741	2021-07-17	2026-05-07 19:10:35	2026-05-07 19:10:35
3	anas	ghali	\N	anas@test.com	$2y$12$jm9d6W9xTrnsdSM1O5uTo.K1hLDYJlyMIgyAjaxbYtSxTswV23X7m	$2y$12$ZBKrQ3PlDxcRzrLInZihW.MFdgsPrgrE/aQ3KNM7Kusz9RJ1EqBoW	0611111111	Tanger	Mesnana,Tanger	11/55455	2023-02-15	2026-05-07 21:15:45	2026-05-07 21:15:45
4	Ghali	azzize	\N	azzize@gmail.com	$2y$12$NwqKwDiiAfGgV8r8mgTgJuYPccrVepJWJFGPuZCfIrNuERVyhp3aS	$2y$12$boVO5c4a2c.TRm/fMTcoeOdGeX/1Ty/F0pNlAWsw/4mnA45PEKDgO	+2126987456321	Tanger	Mesnana,Tanger	12/875554	2005-01-08	2026-05-08 14:57:54	2026-05-08 14:57:54
5	Ghali	Saad	\N	saad@gmail.com	$2y$12$a1foDUVuRprE6CI6k/X2iuz.DoqgbP5DvAUOAGeP.FILp27I79jne	$2y$12$Wp6O7lxV5ZrWBqLIiCs5Q.ixqjznw3C/8W/SdNY84YISs8xZzmKT.	+212769852314	Tanger	Mesnana,Tanger	11/45548	2026-05-02	2026-05-15 22:43:43	2026-05-15 22:43:43
6	Ghali	Saad	\N	saad55@gmail.com	$2y$12$nKXB.MknjoBlfiEnI3m/eePiPfOh7ARqTfMyfAmUxl1XByLLsSnga	$2y$12$dpxmrYAxFYEcuW6XJaLTo.UTNUogrMWHsfpqz1j/ZpOJ9Bb9kVwE2	+212769852314	Tanger	Mesnana,Tanger	11/45548	2026-05-02	2026-05-15 22:44:15	2026-05-15 22:44:15
7	Ghali	Saad	\N	saad100@gmail.com	$2y$12$/suLkD6iVMpjJJuxsY5RwuJEN6NDlTAr1F.b80FyKaSjH5f0yT1N2	$2y$12$LnHyODcNtDTXWEpQnlBSB.rn/EML4jJoc8znbMjfAsjaCtJzq0IG2	+212769852314	Tanger	Mesnana,Tanger	11/45548	2026-05-02	2026-05-15 22:44:31	2026-05-15 22:44:31
8	Ghali	Saad	\N	ghali@gmail.com	$2y$12$cY06t/HS8RLU.zXqNcC37O5YnQAWSaZDxNoAbX5q3EtfdtBILrLbe	$2y$12$Zlzy.ln3b1p7vWLh2DCXcuwkvUm.JmsublLX66tNaUObS6LtLAM6K	+212769852314	Tanger	Mesnana,Tanger	11/45548	2026-05-02	2026-05-15 22:44:55	2026-05-15 22:44:55
9	Ghali	anas	\N	anas@gmail.com	$2y$12$liO26uqjd1EFMwXCwR55AemZn.hxenitCJ8f/aWSCTAvBU13652cG	$2y$12$94Zc7UVMUFChey8L7hZzuuteS38fwwiS1X7wkmgmvmeLRCiuBU8b6	+2127862562	Fès	Fes,Bb	11/7512	2026-05-28	2026-05-16 00:12:17	2026-05-16 00:12:17
10	sddd	dddd	\N	ssss@gmail.com	$2y$12$/Mwihj4fMRV7cUNyPXDv6.IFDiqSCq6UVDsxzwT96ZDD7ANhJ2Om.	$2y$12$Nj/1wTOuUlFs2wSH0rpaaugkEZzLWQWOqBN78G2LLbTUtPJXaCDQa	+2128467894	Kenitra	dwd	11/44654	2026-05-03	2026-05-16 00:25:05	2026-05-16 00:25:05
11	ghazzar	hamza	\N	hamza@gmail.com	$2y$12$QZpm2x0eN1CUeLZZOhg4vuM2LJctq19SET9/nudFoVtIRTgfO3f.m	$2y$12$fKOLNcHtZWKt3R.2O9mvn.5arSqwReNPUAaYBrjTGXh8mnPo3Ik6u	+212698745632	Tanger	Tanger,paussigeur	11/59525	2026-05-04	2026-05-16 19:34:32	2026-05-16 19:34:32
\.


--
-- TOC entry 5044 (class 0 OID 32672)
-- Dependencies: 225
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- TOC entry 5042 (class 0 OID 32664)
-- Dependencies: 223
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- TOC entry 5041 (class 0 OID 32655)
-- Dependencies: 222
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- TOC entry 5035 (class 0 OID 32621)
-- Dependencies: 216
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_04_16_213140_create_permission_tables	1
5	2026_04_18_113016_create_admins_table	1
6	2026_04_18_113033_create_clients_table	1
7	2026_04_18_113042_create_agences_table	1
8	2026_04_18_121309_create_table_roles	1
9	2026_04_18_122122_add_foreign_key_to_users_table	1
10	2026_04_28_215519_drop_columns_from_agences_table	1
11	2026_05_01_145803_drop_columns_to_users_table	1
12	2026_05_01_151612_add_columns_to_agences_table	1
13	2026_05_01_222953_drop_columns_to_users_table	1
14	2026_05_01_235417_create_personal_access_tokens_table	1
15	2026_05_14_000947_create_payments_table	2
16	2026_05_25_232934_add_status_to_agencies_table	3
17	2026_05_31_225110_create_categories_table	4
18	2026_05_31_224919_create_voitures_table	5
19	2026_05_31_224948_create_reservations_table	6
20	2026_06_22_000000_create_sessions_table	7
\.


--
-- TOC entry 5049 (class 0 OID 32705)
-- Dependencies: 230
-- Data for Name: model_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.model_has_permissions (permission_id, model_type, model_id) FROM stdin;
\.


--
-- TOC entry 5050 (class 0 OID 32716)
-- Dependencies: 231
-- Data for Name: model_has_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.model_has_roles (role_id, model_type, model_id) FROM stdin;
2	App\\Models\\User	5
3	App\\Models\\User	6
3	App\\Models\\User	7
3	App\\Models\\User	8
2	App\\Models\\User	9
3	App\\Models\\User	10
2	App\\Models\\User	11
2	App\\Models\\User	12
2	App\\Models\\User	13
2	App\\Models\\User	14
2	App\\Models\\User	15
2	App\\Models\\User	16
2	App\\Models\\User	17
2	App\\Models\\User	18
2	App\\Models\\User	19
2	App\\Models\\User	20
2	App\\Models\\User	21
2	App\\Models\\User	22
2	App\\Models\\User	23
2	App\\Models\\User	24
2	App\\Models\\User	25
3	App\\Models\\User	26
3	App\\Models\\User	27
3	App\\Models\\User	28
3	App\\Models\\User	29
3	App\\Models\\User	30
3	App\\Models\\User	31
3	App\\Models\\User	32
2	App\\Models\\User	33
2	App\\Models\\User	34
2	App\\Models\\User	35
2	App\\Models\\User	36
2	App\\Models\\User	37
1	App\\Models\\User	38
\.


--
-- TOC entry 5063 (class 0 OID 32800)
-- Dependencies: 244
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payments (id, agence_id, user_id, plan, billing_cycle, amount, cardholder_name, address, city, postal_code, status, transaction_id, created_at, updated_at) FROM stdin;
1	17	25	starter	yearly	23.20	youssef ghazzar	Merakeshe akedal 15	Marrakech	800000	completed	\N	2026-05-14 00:24:14	2026-05-14 00:24:14
2	17	25	starter	monthly	29.00	youssef	Merakesh akdal	Marrakech	900000	completed	\N	2026-05-14 00:25:47	2026-05-14 00:25:47
3	17	25	starter	monthly	29.00	edfjbvbv	Merakesh akedal	Marrakech	800000	completed	\N	2026-05-14 00:27:00	2026-05-14 00:27:00
4	17	25	starter	monthly	29.00	youssef	Merakesh tan	Marrakech	900000	completed	\N	2026-05-14 00:30:51	2026-05-14 00:30:51
5	17	25	starter	monthly	29.00	youssef ghazzar	Merakesh Tam	Marrakech	700000	completed	\N	2026-05-14 00:32:08	2026-05-14 00:32:08
6	19	34	starter	yearly	23.20	Larmiche safouan	TANGER GEZENAYA RUE 3	Tanger	90000	completed	\N	2026-05-18 00:23:10	2026-05-18 00:23:10
7	19	34	starter	monthly	29.00	Larmihe safouan	TANGER GEZENAYA RUE 13	Tanger	900000	completed	\N	2026-05-18 00:25:27	2026-05-18 00:25:27
8	20	35	starter	monthly	29.00	Larmichesafouan	TANGER GEZENAYA RUE 13	Tanger	90000	completed	\N	2026-05-18 11:20:10	2026-05-18 11:20:10
9	20	35	starter	monthly	29.00	Larmiche safouan	TANGER GEZENAYA RUE 12	Tanger	900000	completed	\N	2026-05-18 11:21:58	2026-05-18 11:21:58
10	21	36	starter	monthly	29.00	Ghali saad	TANGER MESENANA RUE 13	Tanger	90000	completed	\N	2026-05-21 11:02:10	2026-05-21 11:02:10
11	22	37	starter	monthly	29.00	gggggggg	Tnger ff	Tanger	900000	completed	\N	2026-05-22 13:48:05	2026-05-22 13:48:05
\.


--
-- TOC entry 5046 (class 0 OID 32684)
-- Dependencies: 227
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.permissions (id, name, guard_name, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5061 (class 0 OID 32786)
-- Dependencies: 242
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
1	App\\Models\\User	5	api-token	4ea755e91c46906a9ae6d33be7656eee939aec865df16d7d0a261e244a638e3e	["*"]	\N	\N	2026-05-07 16:06:29	2026-05-07 16:06:29
2	App\\Models\\User	6	api-token	12bd80eaf7e4920905f452b5f062e6af6ed1bae9e9218215ca5a5a6181e630cc	["*"]	\N	\N	2026-05-07 16:06:45	2026-05-07 16:06:45
3	App\\Models\\User	7	api-token	cc2145f90631b6fbebd84031a99aa63b5672d1158afdf6f160f8c4ee47c5a35c	["*"]	\N	\N	2026-05-07 19:10:34	2026-05-07 19:10:34
4	App\\Models\\User	8	api-token	f070ce5fbbdba1e59d1ce4e92dc8a2bf7cbd0451c31b53b30f2acb5333281eaf	["*"]	\N	\N	2026-05-07 21:15:45	2026-05-07 21:15:45
5	App\\Models\\User	7	auth_token	e900da5cc1d3989fb852e9d4e1311c6b9971a1ce8fc6ed5ae1ab19b62452ddf9	["*"]	\N	\N	2026-05-07 21:16:31	2026-05-07 21:16:31
6	App\\Models\\User	9	api-token	15cd2c38be8645aa58f00e243fe2a27e22fa7d8764831cf8633f7843048aeec2	["*"]	\N	\N	2026-05-08 00:01:05	2026-05-08 00:01:05
7	App\\Models\\User	10	api-token	4fcc5a040cad5035e612a01bc901e73e67f99282d5f0a73306dd2bd53d7047b6	["*"]	\N	\N	2026-05-08 14:57:53	2026-05-08 14:57:53
8	App\\Models\\User	11	api-token	031f77639465e925aa0cc3b93c5c16705fbf7a1a9561a3b880943d57fd097eb3	["*"]	\N	\N	2026-05-08 21:58:34	2026-05-08 21:58:34
9	App\\Models\\User	12	api-token	e6dc5d130ccf00b28438818091c9336f800c5a0086119b24b1b7a1a0b7cbdd4a	["*"]	\N	\N	2026-05-08 22:22:49	2026-05-08 22:22:49
10	App\\Models\\User	13	api-token	7a04630db21f566468080a9991a0b1ce938e3ae33922b34b0fef48bd822f6788	["*"]	\N	\N	2026-05-08 22:27:45	2026-05-08 22:27:45
11	App\\Models\\User	14	api-token	c2cef823859a45484118b4321553c99807942bca797b9e322bdaec7a0020541e	["*"]	\N	\N	2026-05-08 22:35:11	2026-05-08 22:35:11
12	App\\Models\\User	15	api-token	0a90d29bdbd253a79c78c402ad523a6947a8b5e3eca74909e9b0aa4ea97970f7	["*"]	\N	\N	2026-05-08 22:39:47	2026-05-08 22:39:47
13	App\\Models\\User	16	api-token	3605bece8f8d802e7f38ea1448d245049acfd0e1da251eb70061873bfe85c1a9	["*"]	\N	\N	2026-05-08 22:57:47	2026-05-08 22:57:47
14	App\\Models\\User	17	api-token	8101e76ea9d692c814f0021061000e97b717be6da7880dc864d03218205cdcbb	["*"]	\N	\N	2026-05-09 12:18:11	2026-05-09 12:18:11
15	App\\Models\\User	18	api-token	f0db8135a9c9c029b413d03b91cf7ecf16817d5736a3dcbb5bd5c4bd6dbffdd2	["*"]	\N	\N	2026-05-10 00:29:07	2026-05-10 00:29:07
16	App\\Models\\User	19	api-token	134993bb86935ff8344214149737dd2ac1ec356a374a47bb842802f3813b9851	["*"]	\N	\N	2026-05-10 00:34:26	2026-05-10 00:34:26
17	App\\Models\\User	20	api-token	d8315bf848aaa45e90101dcb5cabc94cf48373b154d8b67bf45991ce088c2d73	["*"]	\N	\N	2026-05-11 00:25:45	2026-05-11 00:25:45
18	App\\Models\\User	21	api-token	8b44789439084918c29f35fb89f236974be87a8568d635dc0fc4973b25a4e482	["*"]	\N	\N	2026-05-11 23:50:49	2026-05-11 23:50:49
19	App\\Models\\User	26	api-token	41b6b5caebc15c5339d14f20f3269de16d5eb8b4864bfcfc3e550bf10b8c0fb5	["*"]	\N	\N	2026-05-15 22:43:41	2026-05-15 22:43:41
20	App\\Models\\User	27	api-token	c980b2243fbac3d4ae384e1159c92429bb422e2f51a5fcfea07230aa8be5f74e	["*"]	\N	\N	2026-05-15 22:44:14	2026-05-15 22:44:14
21	App\\Models\\User	28	api-token	c0f5b1b42b6a19e0f3984187382e3258333e71070845aad55a8e379196ee05b3	["*"]	\N	\N	2026-05-15 22:44:29	2026-05-15 22:44:29
22	App\\Models\\User	29	api-token	1e14d40a6d0214e5326a2eb8e98793918303628a955ae52630ffaddd44d905af	["*"]	\N	\N	2026-05-15 22:44:53	2026-05-15 22:44:53
23	App\\Models\\User	30	api-token	e16cc70633bba033681673fadc773437c6395496b470abf1b23563f25adbacaf	["*"]	\N	\N	2026-05-16 00:12:16	2026-05-16 00:12:16
24	App\\Models\\User	31	api-token	f9bd3cb1c8ce4a82b2768466cd2ccdb064ffb77389f20a4469ca35e8d250c8d6	["*"]	\N	\N	2026-05-16 00:25:04	2026-05-16 00:25:04
25	App\\Models\\User	32	api-token	9b9c0c81b9fa758920f8de3f09c0bf0e315d2fd1945318b4241f2a357716efa1	["*"]	\N	\N	2026-05-16 19:34:31	2026-05-16 19:34:31
\.


--
-- TOC entry 5069 (class 0 OID 32966)
-- Dependencies: 250
-- Data for Name: reservations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reservations (id, user_id, voiture_id, agency_id, date_debut, date_fin, prix_total, statut, notes, created_at, updated_at) FROM stdin;
1	7	6	22	2026-06-20	2026-06-23	360.00	en_attente	\N	2026-06-19 15:33:13	2026-06-19 15:33:13
2	7	4	20	2026-06-21	2026-06-30	1980.00	active	Sade	2026-06-21 19:13:09	2026-06-21 22:29:25
3	26	5	18	2026-06-21	2026-06-22	150.00	active	thnks for sevice	2026-06-21 19:38:56	2026-06-27 00:13:47
\.


--
-- TOC entry 5051 (class 0 OID 32727)
-- Dependencies: 232
-- Data for Name: role_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role_has_permissions (permission_id, role_id) FROM stdin;
\.


--
-- TOC entry 5048 (class 0 OID 32695)
-- Dependencies: 229
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, name, guard_name, created_at, updated_at) FROM stdin;
1	admin	web	2026-05-07 16:06:17	2026-05-07 16:06:17
2	agence	web	2026-05-07 16:06:17	2026-05-07 16:06:17
3	client	web	2026-05-07 16:06:17	2026-05-07 16:06:17
\.


--
-- TOC entry 5070 (class 0 OID 32991)
-- Dependencies: 251
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
\.


--
-- TOC entry 5059 (class 0 OID 32770)
-- Dependencies: 240
-- Data for Name: table_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.table_roles (id, name, guard_name, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5037 (class 0 OID 32628)
-- Dependencies: 218
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, nom, prenom, email, telephone, address, ville, password, confirm_password, email_verified_at, remember_token, created_at, updated_at) FROM stdin;
1	saad	ghali	saad22@test.com	0611111111	\N	Tanger	$2y$12$zhxIjtjZSZOozOWU/Mh4vuUPmOQiHnygJ6G3diR/h0EwBUrmv52vC	\N	\N	\N	2026-05-07 15:53:16	2026-05-07 15:53:16
2	youssef	ghazzar	youssef@agence.com	0713524393	\N	Tanger	$2y$12$2Y1P/xIMZjWcTzrUhzxvOuHfQqnMDUpAm84brHtMRpI2RQg4YSEvK	\N	\N	\N	2026-05-07 15:53:39	2026-05-07 15:53:39
3	youssef	ghazzar	youssef15@agence.com	0713524393	\N	Tanger	$2y$12$zj3gGiel3KlmFBSIrrduD.BNd8uTukZkjF71M5mfaJZYenm2eSyGW	\N	\N	\N	2026-05-07 15:57:53	2026-05-07 15:57:53
4	saad	ghali	saad25@test.com	0611111111	\N	Tanger	$2y$12$0hhsqsiGcVqFMewkdN9hn.L2kLRyHBug/XMblHB5OBBcSkcxV5OV6	\N	\N	\N	2026-05-07 15:58:12	2026-05-07 15:58:12
5	youssef	ghazzar	youssef25@agence.com	0713524393	\N	Tanger	$2y$12$DQXSdvGC9YNOF8a.miwG0ObF/j2TjXnoTm8odklZ1hCNU2UB2p3Se	\N	\N	\N	2026-05-07 16:06:29	2026-05-07 16:06:29
6	saad	ghali	saad2006@test.com	0611111111	\N	Tanger	$2y$12$SjPKhDAlHQitAOUAbNNeBu5.CYLdScOTqRLisC6A4gW7nIkNyYj/e	\N	\N	\N	2026-05-07 16:06:45	2026-05-07 16:06:45
7	Ben ayad	karim	karim25@gmail.com	+2127896317895	\N	Rabat	$2y$12$oHfjm5tLLz6rn0IVuVQoMOqC48gij3fi/SbKU4uLNow/keWxS27be	\N	\N	\N	2026-05-07 19:10:33	2026-05-07 19:10:33
8	anas	ghali	anas@test.com	0611111111	\N	Tanger	$2y$12$sPqhebVMd2Ed5dbE2LT4nuGygaF1Xv/jpnaGhjTLewJDyccVn0DAO	\N	\N	\N	2026-05-07 21:15:44	2026-05-07 21:15:44
9	ghazzar	soulaiman	soulaiman@gmail.com	+212785471236	\N	Tanger	$2y$12$MWdx4GBw/JWH/24EfuWRu.2gqxLayvPPb50Qf0zlg9v2CSidxGg0W	\N	\N	\N	2026-05-08 00:01:04	2026-05-08 00:01:04
10	Ghali	azzize	azzize@gmail.com	+2126987456321	\N	Tanger	$2y$12$itixp3luiAk1uP5655T4rO964LFRBZgvALV6zeVFyBUqjE1wNRLOe	\N	\N	\N	2026-05-08 14:57:52	2026-05-08 14:57:52
11	benmoumn	adil	adil@gmail.com	+21278965412	\N	Tétouan	$2y$12$ZxK6dfqUri/l7jLxyu4.v.iECJ6IFqKH/EIkW1UN0BFpGUUhA1RCq	\N	\N	\N	2026-05-08 21:58:33	2026-05-08 21:58:33
12	dddd	dwww	youssefghazzar15@gmail.com	+21278965241	\N	Tétouan	$2y$12$P4.xYsZ9.4lrhyAnac3I/eSrmXJANQscbOnir5v6wOYV0IxQVT8qG	\N	\N	\N	2026-05-08 22:22:49	2026-05-08 22:22:49
13	bbb	bbbb	youssefghazzar20@gmail.com	+21268547925	\N	Laâyoune	$2y$12$0JJBGM2qqvnGiTDGiZKVL.WauLT3ZyorL3rBn/Cgd0FY7jjo7Kilu	\N	\N	\N	2026-05-08 22:27:44	2026-05-08 22:27:44
14	ddddd	dddddd	youssefghazzar25@gmail.com	+21258444448	\N	Marrakech	$2y$12$B87QUxamPyHLH9.Y9hvCH.oOD1Ul9G.f06Dn5sgPjp/zZ0HKyEqNq	\N	\N	\N	2026-05-08 22:35:11	2026-05-08 22:35:11
15	ffffff	ffffffffff	youssefghazzar35@gmail.com	+21278965412	\N	Oujda	$2y$12$1zoPHJ31GgNdVGVKkFWHvuKClyIomQNFxoOCMRFuTbPZwo.a87lTO	\N	\N	\N	2026-05-08 22:39:47	2026-05-08 22:39:47
16	ffffffffffff	ffffffffffffffffffffff	youssefghazzar45@gmail.com	+212651616165	\N	Kenitra	$2y$12$rjP0X0iJhSdeQ/qrEao3ouTrMeOmlDaLhfCZ1Dg0PGeOVsX96IJJq	\N	\N	\N	2026-05-08 22:57:47	2026-05-08 22:57:47
17	ddddddddddddddddddd	dddddddddddddddddddddd	youssefghazzar55@gmail.com	+212687453214	\N	Fès	$2y$12$ZgEzsStXOtWOvOyA02wo8.8dnQbhmAVIGvGleX.2Xfe7Y9MMO8o8m	\N	\N	\N	2026-05-09 12:18:11	2026-05-09 12:18:11
18	ddddddddddddddd	ssssssssssssss	youssefghazzar65@gmail.com	+2124884441	\N	Casablanca	$2y$12$fT082zE2haLWivh4ab0nWu5H3xCCCvwxn.ceGS6AKGjK9J8n9QMBS	\N	\N	\N	2026-05-10 00:29:06	2026-05-10 00:29:06
19	cccccc	ccccccccc	youssefghazzar85@gmail.com	+212648148584	\N	Rabat	$2y$12$q0vo/asTH65i1yt2vVWjGeU17WljtM7UOlnequJNt0LFJZGce.4ra	\N	\N	\N	2026-05-10 00:34:26	2026-05-10 00:34:26
20	ggggggggggg	ggggggggggggggggg	youssefghazzar@gmail.com	+212752148561	\N	Tanger	$2y$12$DFKK.rylbHXSKBdZqoUkcOR4L1RLvZT3a/GhXyXItNHnwSWmUDxS6	\N	\N	\N	2026-05-11 00:25:44	2026-05-11 00:25:44
21	ddddddddddddddddd	ddddddddddddddddd	dddd@gmail.com	+2125555558	\N	Agadir	$2y$12$kCwYrcpIere9snisvjDj0.gn1fJQNEoW6by.UKy5JlC4o/XmA31dy	\N	\N	\N	2026-05-11 23:50:48	2026-05-11 23:50:48
22	ggggggggggggggggg	gggggggggggggggg	ggggggggggggg@gmail.com	+21275848935	\N	El Jadida	$2y$12$2auztaY0QOUQ0jD/KVhu7./WRMV5MBemAGc0AQWhQP7OvOLMC1LyG	\N	\N	\N	2026-05-12 00:13:26	2026-05-12 00:13:26
23	hhgh	urfiu	youssefghazza222r@gmail.com	+212545694695	\N	Meknès	$2y$12$oMyxF0nOHo6J44DJPk1y3O.mYJdygfe48RhfWc/YJ26h8NAb3C/d.	\N	\N	\N	2026-05-13 23:51:31	2026-05-13 23:51:31
24	ddddddddddd	ddddddddddddddd	youssefghazzar95@gmail.com	+21244554548	\N	Rabat	$2y$12$PawcJaFc/xDrz2oZSy2L0ejzzkVeFN2WROWP9CLsKe1nbiAaXzB.S	\N	\N	\N	2026-05-14 00:19:30	2026-05-14 00:19:30
25	hiuhfr	frvfevvr	youssefghazzzar123@gmail.com	+212541485485	\N	Marrakech	$2y$12$FNfewE5ht9H/rgqq5Qp.fuS8hpQv.FxsaY8hgMwow2SWMvx7.n63G	\N	\N	\N	2026-05-14 00:23:07	2026-05-14 00:23:07
26	Ghali	Saad	saad@gmail.com	+212769852314	\N	Tanger	$2y$12$3pXmRgA.QlNgoqnG7vWwO.3xURfvvw1t8S3Sr6lJHElF2nwkYd8TC	\N	\N	\N	2026-05-15 22:43:41	2026-05-15 22:43:41
27	Ghali	Saad	saad55@gmail.com	+212769852314	\N	Tanger	$2y$12$Au.XhFETINw8UbfgxIZ11OUd3UzxVA8AnKHK53HzBRXBZvTuD31z6	\N	\N	\N	2026-05-15 22:44:14	2026-05-15 22:44:14
28	Ghali	Saad	saad100@gmail.com	+212769852314	\N	Tanger	$2y$12$Iycsup5bc9za3Yc8BeSBFuAOLQQK9XR1mSNsqLhZTmr/B7t95MrpS	\N	\N	\N	2026-05-15 22:44:29	2026-05-15 22:44:29
29	Ghali	Saad	ghali@gmail.com	+212769852314	\N	Tanger	$2y$12$46Hmhdb1H6j6K/yXctASA.WM17Iac6oV9bUoQDpgMhpDJTduuAA5a	\N	\N	\N	2026-05-15 22:44:53	2026-05-15 22:44:53
30	Ghali	anas	anas@gmail.com	+2127862562	\N	Fès	$2y$12$cCQ9v.cyzfzgF8qFar1k9.8e8UcBgItKkwfCY9BieOJj9nrzXl16y	\N	\N	\N	2026-05-16 00:12:16	2026-05-16 00:12:16
31	sddd	dddd	ssss@gmail.com	+2128467894	\N	Kenitra	$2y$12$gphOkoKPSAPq4/IcrEEdk.nVzI/WFSDlAUh36MFWIRQ6QpfLQKSlK	\N	\N	\N	2026-05-16 00:25:04	2026-05-16 00:25:04
32	ghazzar	hamza	hamza@gmail.com	+212698745632	\N	Tanger	$2y$12$nZnZKk1o5/i9z7mdqOHXouhZYg/V6wPzgn35ysUU2uO4chSpfW1r2	\N	\N	\N	2026-05-16 19:34:30	2026-05-16 19:34:30
33	larmiche	safouan	safouan@gmail.com	+21278965412	\N	Tanger	$2y$12$srAQWQijvYggVvMYPNueR.odXY0aAwNdvqPC/oLw8SLA3wI.yoxfa	\N	\N	\N	2026-05-18 00:15:48	2026-05-18 00:15:48
34	larmiche	safouan	safouan2@gmail.com	+21278965412	\N	Tanger	$2y$12$xoojd/EmJ.d8An/GFfUni.XUc2GejkUoA2ynVwFfdulz58Ro21LRu	\N	\N	\N	2026-05-18 00:21:43	2026-05-18 00:21:43
35	larmiche	safouan	safouan3@gmail.com	+21276985412	\N	Tanger	$2y$12$Xh/au.qNwOhR3c52YKsdX.t5UobiuaA36icx1GxnB0q5CpcHA5fsi	\N	\N	\N	2026-05-18 11:19:07	2026-05-18 11:19:07
36	ghali	saad	fastdrive@gmail.com	+2127896541	\N	Tanger	$2y$12$Xzciq3xdMF1PJp7Tih1VNOJrzp8Bpw6lDShIb5rGg3Gwl.UJMF.v.	\N	\N	\N	2026-05-21 10:59:18	2026-05-21 10:59:18
37	ghali	anas	ghali55@gmail.com	07848454	\N	Tanger	$2y$12$lYe1SM7yXhsqVmJ.2t6aL.jBJlEVAyiurEpbFvTHrIW5zNvUHFf2.	\N	\N	\N	2026-05-22 13:47:08	2026-05-22 13:47:08
38	Super	Admin	admin@atlasdrive.com	0600000000	\N	Tangier	$2y$12$SZ7gitkjsKgUnf/KYxJF4OGRuM78y.6MY98xC.4pyteudhHeRSeRW	\N	\N	\N	2026-05-24 23:49:53	2026-05-24 23:49:53
\.


--
-- TOC entry 5067 (class 0 OID 32920)
-- Dependencies: 248
-- Data for Name: voitures; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.voitures (id, agency_id, category_id, marque, modele, annee, immatriculation, prix_par_jour, nb_places, transmission, carburant, couleur, image, disponible, description, created_at, updated_at) FROM stdin;
5	18	5	Dacia	Duster	2023	MA-88-AV	150.00	5	manuelle	essence	Black	storage/images/QVAD5wCGXSkdB4HhRfQfjAanEofzYtcbzdCVbGnT.jpg	f	\N	2026-06-19 08:15:11	2026-07-01 13:53:20
1	20	4	Tesla	Model S	2024	AA-123-BB	150.00	5	automatique	electrique	Noir	storage/images/teslamodels.png	t	Une berline électrique haut de gamme avec pilotage automatique et un confort exceptionnel.	2026-06-04 00:21:21	2026-06-04 00:21:21
6	22	3	peugeot	208	2023	511585	120.00	5	manuelle	essence	Yellow	storage/images/2md2jBytIfRk7XSLvmVCRLfNdJnId74x8W0SIJrd.webp	t	\N	2026-06-19 08:49:32	2026-06-19 15:36:18
4	20	5	Volsvagen	Golf 8	2022	A41 87	220.00	5	manuelle	essence	Black	storage/images/volkswagen-golf-mk8-gte-hatchback.png	f	\N	2026-06-17 15:14:25	2026-06-30 16:43:32
8	20	5	Porshe	911	2023	Db4848	250.00	5	manuelle	essence	Grey	storage/images/téléchargement.png	t	\N	2026-06-22 14:19:36	2026-06-30 16:43:48
7	20	1	KIA	sorento	2022	40k44	140.00	5	manuelle	essence	white	storage/images/GZEDpKe1J3pv63xhRNx80457XucrLpFBDCqDQBOF.jpg	t	\N	2026-06-22 14:15:23	2026-06-30 16:44:03
\.


--
-- TOC entry 5091 (class 0 OID 0)
-- Dependencies: 233
-- Name: admins_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.admins_id_seq', 1, false);


--
-- TOC entry 5092 (class 0 OID 0)
-- Dependencies: 237
-- Name: agences_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.agences_id_seq', 22, true);


--
-- TOC entry 5093 (class 0 OID 0)
-- Dependencies: 245
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 5, true);


--
-- TOC entry 5094 (class 0 OID 0)
-- Dependencies: 235
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_id_seq', 11, true);


--
-- TOC entry 5095 (class 0 OID 0)
-- Dependencies: 224
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 5096 (class 0 OID 0)
-- Dependencies: 221
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- TOC entry 5097 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 20, true);


--
-- TOC entry 5098 (class 0 OID 0)
-- Dependencies: 243
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payments_id_seq', 11, true);


--
-- TOC entry 5099 (class 0 OID 0)
-- Dependencies: 226
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permissions_id_seq', 1, false);


--
-- TOC entry 5100 (class 0 OID 0)
-- Dependencies: 241
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 25, true);


--
-- TOC entry 5101 (class 0 OID 0)
-- Dependencies: 249
-- Name: reservations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reservations_id_seq', 3, true);


--
-- TOC entry 5102 (class 0 OID 0)
-- Dependencies: 228
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 1, false);


--
-- TOC entry 5103 (class 0 OID 0)
-- Dependencies: 239
-- Name: table_roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.table_roles_id_seq', 1, false);


--
-- TOC entry 5104 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 38, true);


--
-- TOC entry 5105 (class 0 OID 0)
-- Dependencies: 247
-- Name: voitures_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.voitures_id_seq', 9, true);


--
-- TOC entry 4849 (class 2606 OID 32748)
-- Name: admins admins_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_pkey PRIMARY KEY (id);


--
-- TOC entry 4855 (class 2606 OID 32768)
-- Name: agences agences_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agences
    ADD CONSTRAINT agences_pkey PRIMARY KEY (id);


--
-- TOC entry 4857 (class 2606 OID 32784)
-- Name: agences agences_user_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agences
    ADD CONSTRAINT agences_user_id_unique UNIQUE (user_id);


--
-- TOC entry 4822 (class 2606 OID 32652)
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- TOC entry 4819 (class 2606 OID 32644)
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- TOC entry 4869 (class 2606 OID 32916)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- TOC entry 4871 (class 2606 OID 32918)
-- Name: categories categories_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_slug_unique UNIQUE (slug);


--
-- TOC entry 4851 (class 2606 OID 32759)
-- Name: clients clients_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_email_unique UNIQUE (email);


--
-- TOC entry 4853 (class 2606 OID 32757)
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- TOC entry 4829 (class 2606 OID 32680)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4831 (class 2606 OID 32682)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 4827 (class 2606 OID 32670)
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- TOC entry 4824 (class 2606 OID 32662)
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4812 (class 2606 OID 32626)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 4842 (class 2606 OID 32715)
-- Name: model_has_permissions model_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);


--
-- TOC entry 4845 (class 2606 OID 32726)
-- Name: model_has_roles model_has_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);


--
-- TOC entry 4867 (class 2606 OID 32808)
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);


--
-- TOC entry 4833 (class 2606 OID 32693)
-- Name: permissions permissions_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);


--
-- TOC entry 4835 (class 2606 OID 32691)
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- TOC entry 4862 (class 2606 OID 32793)
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 4864 (class 2606 OID 32796)
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- TOC entry 4877 (class 2606 OID 32975)
-- Name: reservations reservations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_pkey PRIMARY KEY (id);


--
-- TOC entry 4847 (class 2606 OID 32741)
-- Name: role_has_permissions role_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);


--
-- TOC entry 4837 (class 2606 OID 32704)
-- Name: roles roles_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);


--
-- TOC entry 4839 (class 2606 OID 32702)
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- TOC entry 4879 (class 2606 OID 32997)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 4859 (class 2606 OID 32777)
-- Name: table_roles table_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_roles
    ADD CONSTRAINT table_roles_pkey PRIMARY KEY (id);


--
-- TOC entry 4814 (class 2606 OID 32637)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 4816 (class 2606 OID 32635)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 4873 (class 2606 OID 32943)
-- Name: voitures voitures_immatriculation_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.voitures
    ADD CONSTRAINT voitures_immatriculation_unique UNIQUE (immatriculation);


--
-- TOC entry 4875 (class 2606 OID 32931)
-- Name: voitures voitures_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.voitures
    ADD CONSTRAINT voitures_pkey PRIMARY KEY (id);


--
-- TOC entry 4817 (class 1259 OID 32645)
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- TOC entry 4820 (class 1259 OID 32653)
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- TOC entry 4825 (class 1259 OID 32663)
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- TOC entry 4840 (class 1259 OID 32708)
-- Name: model_has_permissions_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);


--
-- TOC entry 4843 (class 1259 OID 32719)
-- Name: model_has_roles_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);


--
-- TOC entry 4860 (class 1259 OID 32797)
-- Name: personal_access_tokens_expires_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_expires_at_index ON public.personal_access_tokens USING btree (expires_at);


--
-- TOC entry 4865 (class 1259 OID 32794)
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- TOC entry 4880 (class 2606 OID 32709)
-- Name: model_has_permissions model_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- TOC entry 4881 (class 2606 OID 32720)
-- Name: model_has_roles model_has_roles_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- TOC entry 4884 (class 2606 OID 32809)
-- Name: payments payments_agence_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_agence_id_foreign FOREIGN KEY (agence_id) REFERENCES public.agences(id) ON DELETE CASCADE;


--
-- TOC entry 4885 (class 2606 OID 32814)
-- Name: payments payments_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 4888 (class 2606 OID 32986)
-- Name: reservations reservations_agency_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_agency_id_foreign FOREIGN KEY (agency_id) REFERENCES public.agences(id) ON DELETE CASCADE;


--
-- TOC entry 4889 (class 2606 OID 32976)
-- Name: reservations reservations_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 4890 (class 2606 OID 32981)
-- Name: reservations reservations_voiture_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_voiture_id_foreign FOREIGN KEY (voiture_id) REFERENCES public.voitures(id) ON DELETE CASCADE;


--
-- TOC entry 4882 (class 2606 OID 32730)
-- Name: role_has_permissions role_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- TOC entry 4883 (class 2606 OID 32735)
-- Name: role_has_permissions role_has_permissions_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- TOC entry 4886 (class 2606 OID 32932)
-- Name: voitures voitures_agency_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.voitures
    ADD CONSTRAINT voitures_agency_id_foreign FOREIGN KEY (agency_id) REFERENCES public.agences(id) ON DELETE CASCADE;


--
-- TOC entry 4887 (class 2606 OID 32937)
-- Name: voitures voitures_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.voitures
    ADD CONSTRAINT voitures_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE RESTRICT;


-- Completed on 2026-07-02 09:38:08

--
-- PostgreSQL database dump complete
--


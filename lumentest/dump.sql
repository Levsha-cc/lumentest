\connect "lumenlogs";

DROP TABLE IF EXISTS "story";
CREATE TABLE "public"."story" (
    "date" timestamp NOT NULL,
    "ip" cidr NOT NULL,
    "url_from" text NOT NULL,
    "url_to" text NOT NULL,
    CONSTRAINT "story_ip_fkey" FOREIGN KEY (ip) REFERENCES users(ip) NOT DEFERRABLE
) WITH (oids = false);

CREATE INDEX "story_ip" ON "public"."story" USING btree ("ip");


DROP TABLE IF EXISTS "users";
CREATE TABLE "public"."users" (
    "ip" cidr NOT NULL,
    "browser" character(255) NOT NULL,
    "os" character(25) NOT NULL,
    CONSTRAINT "users_ip" UNIQUE ("ip")
) WITH (oids = false);

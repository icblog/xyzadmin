<template>
  <Layout pageTitle="about-me">
    <div class="container">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <div class="page-intro-wrapper">
            <h1>More about me</h1>
            <p>
              Hi again and thank you for taking the time to check out my personal website,
              read more about me below.
            </p>
          </div>
          <div class="about-detail-wrapper">
            <section class="pb-3">
              <Accordion
                :key="0"
                :activeIndex="currentlyActiveIndex"
                :itemIndex="0"
                @update:itemIndex="currentlyActiveIndex = $event"
              >
                <template v-slot:accordion-trigger> History </template>
                <template v-slot:accordion-content>
                  <p>
                    Around 2015 my interest in web tech became stronger and therefore
                    decided to take my first coding lessions in HTML & Javascript on
                    <a
                      class="w3c-link"
                      href="https://www.w3schools.com/"
                      rel="noreferrer"
                      target="_blank"
                      >w3schools website</a
                    >
                    and ever since I produced the famous <strong>"Hello World"</strong> to
                    the console of my first application I knew I have found a new hobby.
                  </p>
                  <p>
                    What started as hobby and a simple
                    <strong>"Hello World"</strong> application has become a full blown
                    passion of mine as years gone by and has offered me opportunity to
                    constantly learn and further develope my skills in solving complex
                    logic behind creating web applications.
                  </p>
                </template>
              </Accordion>
            </section>
            <section class="pb-3">
              <Accordion
                :key="1"
                :activeIndex="currentlyActiveIndex"
                :itemIndex="1"
                @update:itemIndex="currentlyActiveIndex = $event"
              >
                <template v-slot:accordion-trigger> Experience/Projects </template>
                <template v-slot:accordion-content>
                  <div class="row">
                    <div class="col-md-12">
                      <p>
                        Below are a few projects I have completed over the course of
                        learning to code.
                      </p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="box-shadow project-detail">
                        <img
                          src="../../../public/images/adom.jpg"
                          class="project-img"
                          alt="Adom Ballons"
                        />
                        <p>
                          Responsive event decoration website for a client to showcase
                          their work.<br />
                          <strong>Key features:</strong><br />
                          <span class="tech-stack-name">Responsive . </span>
                          <span class="tech-stack-name">
                            User Registration &amp; Authentication .
                          </span>
                          <span class="tech-stack-name"> Admin CRUD . </span>
                          <span class="tech-stack-name"> Star Rating system</span>
                          <br />
                          <strong>Main tech stack:</strong><br />
                          <span class="tech-stack-name">HTML . </span>
                          <span class="tech-stack-name"> Scss . </span>
                          <span class="tech-stack-name"> Javascript . </span>
                          <span class="tech-stack-name"> Jquery . </span>
                          <span class="tech-stack-name"> Bootstrap . </span>
                          <span class="tech-stack-name"> Php . </span>
                          <span class="tech-stack-name"> Mysql . </span>
                          <span class="tech-stack-name"> Laravel </span>

                          <span class="source-link-wrapper"
                            ><a
                              href="https://adomballoons.42web.io"
                              rel="noreferrer"
                              target="_blank"
                              ><strong>Site link</strong></a
                            >
                            <strong>.</strong>
                            <a
                              href="https://github.com/icblog/icblog-portfolio"
                              rel="noreferrer"
                              target="_blank"
                              ><strong>Source code</strong></a
                            ></span
                          >
                        </p>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="box-shadow project-detail">
                        <img
                          src="../../../public/images/icblog.png"
                          class="project-img"
                          alt="Icblog"
                        />
                        <p>
                          This is the site you're browsing. Here, I showcase my skills and
                          what I know so far with a blog section to give something back to
                          the online community that has been a huge part of my coding
                          journey.<br />
                          <strong>Key features:</strong><br />
                          <span class="tech-stack-name">Responsive . </span>
                          <span class="tech-stack-name">
                            User Registration &amp; Authentication .
                          </span>
                          <span class="tech-stack-name"> Admin CRUD . </span>

                          <br />
                          <strong>Main tech stack:</strong><br />

                          <span class="tech-stack-name">HTML . </span>
                          <span class="tech-stack-name"> Scss .</span>
                          <span class="tech-stack-name"> React Js .</span>
                          <span class="tech-stack-name"> Bootstrap . </span>
                          <span class="tech-stack-name"> Php . </span>
                          <span class="tech-stack-name"> Mysql . </span>
                          <span class="tech-stack-name"> Laravel </span>

                          <span class="source-link-wrapper"
                            ><a
                              href="https://github.com/icblog/icblog-portfolio"
                              rel="noreferrer"
                              target="_blank"
                              ><strong>Source code</strong></a
                            ></span
                          >
                        </p>
                      </div>
                    </div>
                  </div>
                </template>
              </Accordion>
            </section>
            <section class="pb-3">
              <Accordion
                :key="2"
                :activeIndex="currentlyActiveIndex"
                :itemIndex="2"
                @update:itemIndex="currentlyActiveIndex = $event"
              >
                <template v-slot:accordion-trigger> Skills </template>
                <template v-slot:accordion-content>
                  <p>
                    I'm constantly learning new stack to add onto my skills however, below
                    are what I'm currently familiar with.
                  </p>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="box-shadow skill-detail project-detail">
                        <p class="skills-heading-p">Languages</p>
                        <span> Html/Html5</span> . <span> Css/Css3/Scss</span> .
                        <span> JavaScript</span> .
                        <span> Php</span>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="box-shadow skill-detail project-detail">
                        <p class="skills-heading-p">Frameworks</p>
                        <span>Laravel/Blade</span> . <span> Bootstrap</span> .
                        <span> Jquery/Ajax</span> . <span> React Js</span> .
                        <span> Vue Js</span> .
                        <span> Inertia Js</span>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="box-shadow skill-detail project-detail">
                        <p class="skills-heading-p">Database &amp; Drivers</p>
                        <span>Mysql/PhpMyAdmin</span> .
                        <span> MongoDB</span>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="box-shadow skill-detail project-detail">
                        <p class="skills-heading-p">Tools &amp; Systems</p>
                        <span>Npm</span> . <span> Composer</span> .
                        <span> Git/Github</span> .
                        <span> VS code</span>
                      </div>
                    </div>
                  </div>
                </template>
              </Accordion>
            </section>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import Layout from "../shared/Layout";
import Modal from "../shared/Modal.vue";
import Accordion from "../shared/Accordion.vue";

export default {
  components: { Layout, Modal, Accordion },
  data() {
    return {
      currentlyActiveIndex: null,
    };
  },
};
</script>

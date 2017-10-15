var pflMatrix={
	indicators:{
		ixSH:{id:'ixSH', title:'Humour', dispOrder:0, descriptions:{
							default_en:"Exceptionally keen sense of the comical, the bizarre, or absurd.",
							kids_en:"I get totally silly about these things. My sense of humour goes wild."
							}
		},
		ixEIC:{id:'ixEIC',title:'Imagination & creativity', dispOrder:1, descriptions:{
							default_en:"Extraordinary ability to use ideas, processes, materials or anything else in ingenious, flexible or surprising ways.",
							kids_en:"I have a wild imagination. I say things, do things, think things, feel things in a way other kids don't."
							}
		},
		ixPIM:{id:'ixPIM', title:'Inquiry',  dispOrder:2, descriptions:{
							default_en:"Probes deeply while exploring ideas & topics; asks deep questions; experiments with events, ideas, feelings, sounds, symbols, movement, etc.",
							kids_en:"I need to find answers to my own questions more than the teacher's questions. I want to test my ideas to see what might work & why."
							}
		},
		ixTM:{id:'ixTM', title:'Memory & processing',  dispOrder:3, descriptions:{
							default_en:"Tremendous capacity for dealing with large amounts of information & skills.",
							kids_en:"I know lots more about this than any other kid my age."
							}
		},
		ixISA:{id:'ixISA',title:'Sensitivity',  dispOrder:4 ,descriptions:{
							default_en:"Unusually aware of or responsive to her/his own experiences & feelings &/or those of others.",
							kids_en:"I'm very sensitive. My feelings about these kinds of activities & the people I do them with are very strong."
							}
		},
		ixGC:{id:'ixGC',title:'Expressiveness',  dispOrder:5, descriptions:{
							default_en:"Extraordinary ability to communicate meaning or emotion through words, actions, symbols, sounds, or media.",
							kids_en:"I can explain my ideas very clearly. My explanations may be in words & numbers, but they might also be in actions or symbols or music or movement."
							}
		},
		ixRTW:{id:'ixRTW',title:'Reasoning',  dispOrder:6, descriptions:{
							default_en:"Loves to think; thinks things through; considers implications or alternatives; rich, flexible, highly conscious, analytical or logical thought. Thinking is not necessarily directed toward a goal or solution.",
							kids_en:"I love thinking about these kinds of things. I like to come up with lots of ideas & then predict the consequences before trying to do them."
							}
		},		
		ixSCP:{id:'ixSCP',title:'Problem-solving',  dispOrder:7, descriptions:{
							default_en:"Outstanding ability to find systematic solutions to problems; is able to invent & monitor many paths to a goal; seeks out challenging problems.",
							kids_en:"I love to solve hard, messy problems by inventing & checking lots of different solutions. I live for the challenge!"
							}
		},		
		ixIU:{id:'ixIU',title:'Intuition',  dispOrder:8, descriptions:{
							default_en:"Suddenly discovers connections or deeper meanings without conscious awareness of reasoning or thought.",
							kids_en:"I see connections between ideas that other kids don't. I can't explain how I know -- I just know!"
							}
		},		
		ixLE:{id:'ixLE',title:'Learning',  dispOrder:9, descriptions:{
							default_en:"Extremely able to grasp & use sophisticated new understandings quickly & easily.",
							kids_en:"I love learning the tough stuff. It's much easier for me to learn it than it is for other kids my age."
							}
		},		
		ixAPI:{id:'ixAPI',title:'Interests',  dispOrder:10, descriptions:{
							default_en:"Advanced, intensely focused curiosity; passionate; may focus on unusual topics; interest is sometimes fleeting but always intense.",
							kids_en:"I absolutely love this stuff, even if other kids think it's weird."
							}
		},				
		ixMEC:{id:'ixMEC',title:'Moral & ethical concerns',  dispOrder:11, descriptions:{
							default_en:"Extreme need for fairness & justice; will take action to resolve injustices; deeply concerned with the consequences of her or his actions.",
							kids_en:"I need to believe in an idea before doing anything about it. If it isn't fair to everyone or if it just feels wrong, I won't do it."
							}
		},				
		ixHMP:{id:'ixHMP',title:'Motivation',  dispOrder:12, descriptions:{
							default_en:"Persistent, intense need to know, do, feel, create, or understand.",
							kids_en:"I want MORE! Once I start I can't shut my mind off. I can't quit even when I run out of time in class."
							}
		}					
	},
	diffOptions:{
		contAbs:{
			id:"contAbs",title:"Abstractness", type: "content", indicators:['ixTM','ixGC','ixSCP','ixRTW','ixLE','ixMEC'], refId:181, descriptions:{
						default_en:"The content focuses on abstract concepts, themes, generalizations & theories, not concrete facts. It addresses ideas that have a wide range of applicability.",
						kids_en:"The content focuses on abstract concepts, themes, generalizations & theories, not concrete facts. It addresses ideas that have a wide range of applicability."
					}
		},
		contComp:{
			id:"contComp",title:"Complexity", type: "content", indicators:['ixSH','ixPIM','ixTM','ixRTW','ixSCP','ixIU','ixMEC'], refId:183, descriptions:{
						default_en:"Complex content focuses on the interconnections among concepts, principles, generalizations & theories. It is usually interdisciplinary.",
						kids_en:"Complex content focuses on the interconnections among concepts, principles, generalizations & theories. It is usually interdisciplinary."
					}
		},
		extTop:{
			id:"extTop",title:"Extracurricular topics", type: "content", indicators:['ixSH','ixEIC','ixPIM','ixTM','ixLE','ixAPI','ixMEC'], refId:210, descriptions:{
						default_en:"The content includes ideas & content areas not taught in the regular curriculum in any grade. It may include the student's interests.",
						kids_en:"The content includes ideas & content areas not taught in the regular curriculum in any grade. It may include the student's interests."
					}
		},
		livLiv:{
			id:"livLiv",title:"Lives & living", type: "content", indicators:['ixEIC','ixISA','ixMEC','ixHMP'], refId:382, descriptions:{
						default_en:"The content involves the study of creative, productive people (living or dead), their motivations, social characteristics, challenges & career paths.",
						kids_en:"The content involves the study of creative, productive people (living or dead), their motivations, social characteristics, challenges & career paths."
					}
		},
		orgLivVal:{
			id:"orgLivVal",title:"Organization for learning value", type: "content", indicators:['ixTM','ixRTW','ixIU','ixLE','ixMEC'], refId:384, descriptions:{
						default_en:"The content of an entire unit addresses a broad, interdisciplinary theme (like 'systems' or 'patterns') rather than small, sequential bits of information.",
						kids_en:"The content of an entire unit addresses a broad, interdisciplinary theme (like 'systems' or 'patterns') rather than small, sequential bits of information."
					}
		},
		relLiTop:{
			id:"relLiTop",title:"Real life topics", type: "content", indicators:['ixPIM','ixGC','ixRTW','ixSCP','ixAPI','ixMEC','ixHMP'], refId:394, descriptions:{
						default_en:"The content addresses issues, controversies, problems or provocative questions inspired by students' interests, experiences, questions & concerns. Students may need help focusing, analyzing, &/or defining their topic or questions.",
						kids_en:"The content addresses issues, controversies, problems or provocative questions inspired by students' interests, experiences, questions & concerns. Students may need help focusing, analyzing, &/or defining their topic or questions."
					}
		},
		selSelCont:{
			id:"selSelCont",title:"Self-selected content", type: "content", indicators:['ixEIC','ixPIM','ixRTW','ixSCP','ixIU','ixAPI','ixMEC'], refId:398, descriptions:{
						default_en:"The student chooses the content. Some will need help choosing & reducing their interests to topics that are manageable.",
						kids_en:"The student chooses the content. Some will need help choosing & reducing their interests to topics that are manageable."
					}
		},
		cmplxThink:{
			id:"cmplxThink",title:"Complex thinking", type: "process", indicators:['ixSH','ixPIM','ixTM','ixSCP','ixLE','ixMEC'], refId:406, descriptions:{
						default_en:"Emphasize learning processes (verbs) that stress the use, rather than the acquisition of information (higher level thinking, critical thinking, creative thinking, etc.).",
						kids_en:"Emphasize learning processes (verbs) that stress the use, rather than the acquisition of information (higher level thinking, critical thinking, creative thinking, etc.)."
					}
		},		
		expMeths:{
			id:"expMeths",title:"Expert methods", type: "process", indicators:['ixPIM','ixTM','ixGC','ixRTW','ixSCP','ixAPI','ixHMP'], refId:408, descriptions:{
						default_en:"Learning with & about methods used by experts in a discipline.",
						kids_en:"Learning with & about methods used by experts in a discipline."
					}
		},		
		groupInt:{
			id:"groupInt",title:"Group interaction", type: "process", indicators:['ixSH','ixISA','ixGC','ixSCP'], refId:410, descriptions:{
						default_en:"Students collaborate with peers who have similar abilities & share their passions in order to enhance their social & leadership skills, learn perspective-taking & become more empathetic.",
						kids_en:"Students collaborate with peers who have similar abilities & share their passions in order to enhance their social & leadership skills, learn perspective-taking & become more empathetic."
					}
		},		
		indvPurs:{
			id:"indvPurs",title:"Individual pursuits", type: "process", indicators:['ixEIC','ixPIM','ixISA','ixIU','ixAPI','ixHMP'], refId:412, descriptions:{
						default_en:"Individual projects on which students work relatively independently but with the support of a teacher or mentor available as needed.",
						kids_en:"Individual projects on which students work relatively independently but with the support of a teacher or mentor available as needed."
					}
		},		
		inqBasLea:{
			id:"inqBasLea",title:"Inquiry-based learning", type: "process", indicators:['ixEIC','ixPIM','ixTM','ixRTW','ixSCP','ixIU','ixLE','ixAPI','ixHMP'], refId:414, descriptions:{
						default_en:"Inductive reasoning processes are used to discover patterns, underlying principles & generalizations. Students take greater responsibility for their learning than in deductive learning experiences.",
						kids_en:"Inductive reasoning processes are used to discover patterns, underlying principles & generalizations. Students take greater responsibility for their learning than in deductive learning experiences."
					}
		},		
		opEnd:{
			id:"opEnd",title:"Open-endedness", type: "process", indicators:['ixSH','ixEIC','ixPIM','ixISA','ixSCP','ixLE','ixAPI'], refId:417, descriptions:{
						default_en:"Activities involve open-ended questions, activities, projects & methods. These have no predetermined correct outcome. They are provocative, stimulating students to think broadly.",
						kids_en:"Activities involve open-ended questions, activities, projects & methods. These have no predetermined correct outcome. They are provocative, stimulating students to think broadly."
					}
		},		
		pacProc:{
			id:"pacProc",title:"Pacing", type: "process", indicators:['ixPIM','ixTM','ixRTW','ixSCP','ixIU','ixLE','ixHMP'], refId:419, descriptions:{
						default_en:"Students learn at a pace commensurate with their ability to go quickly through or deeply into content. Examples include pretesting, 'compacting', or 'telescoping' curriculum, or other forms of acceleration.",
						kids_en:"Students learn at a pace commensurate with their ability to go quickly through or deeply into content. Examples include pretesting, 'compacting', or 'telescoping' curriculum, or other forms of acceleration."
					}
		},		
		reasRefl:{
			id:"reasRefl",title:"Reasoning & reflection", type: "process", indicators:['ixPIM','ixISA','ixGC','ixRTW','ixSCP','ixMEC'], refId:421, descriptions:{
						default_en:"Students explain their conclusions & the reasoning that led to them as well as the metacognitive aspects of their thinking. They are encouraged to evaluate both the process & products of their own & others' thinking.",
						kids_en:"Students explain their conclusions & the reasoning that led to them as well as the metacognitive aspects of their thinking. They are encouraged to evaluate both the process & products of their own & others' thinking."
					}
		},		
		selSelProc:{
			id:"selSelProc",title:"Self-selected process", type: "process", indicators:['ixEIC','ixPIM','ixTM','ixSCP','ixIU','ixLE','ixAPI','ixHMP'], refId:423, descriptions:{
						default_en:"Students choose the ways they will learn. Some may need assistance identifying their preferences or following through on their choices.",
						kids_en:"Students choose the ways they will learn. Some may need assistance identifying their preferences or following through on their choices."
					}
		},		
		procVariety:{
			id:"procVariety",title:"Variety", type: "process", indicators:['ixSH','ixEIC','ixTM','ixGC','ixRTW','ixSCP','ixLE','ixAPI'], refId:425, descriptions:{
						default_en:"A range of methods of thinking & feeling involved in learning by using different types of problems, resources & technologies.",
						kids_en:"A range of methods of thinking & feeling involved in learning by using different types of problems, resources & technologies."
					}
		},				
		authAud:{
			id:"authAud",title:"Authentic audiences", type: "product", indicators:['ixSH','ixEIC','ixPIM','ixGC','ixRTW','ixSCP','ixMEC'], refId:442, descriptions:{
						default_en:"Results of the learning activity should be shared with real & appropriate audiences  to the greatest extent possible. This may involve the scientific community, the city council, a government agency, art critic, etc.",
						kids_en:"Results of the learning activity should be shared with real & appropriate audiences  to the greatest extent possible. This may involve the scientific community, the city council, a government agency, art critic, etc."
					}
		},				
		feedAssProd:{
			id:"feedAssProd",title:"Feedback & assessment", type: "product", indicators:['ixSH','ixEIC','ixISA','ixRTW','ixSCP','ixMEC','ixHMP'], refId:444, descriptions:{
						default_en:"Products should be assessed using real, predetermined procedures & criteria, & as often as possible, by a member or members of the real audience for the product. Students should also be encouraged or required to self-evaluate their products using the same criteria.",
						kids_en:"Products should be assessed using real, predetermined procedures & criteria, & as often as possible, by a member or members of the real audience for the product. Students should also be encouraged or required to self-evaluate their products using the same criteria."
					}
		},				
		selSelProd:{
			id:"selSelProd",title:"Self-selected product", type: "product", indicators:['ixEIC','ixPIM','ixTM','ixGC','ixLE','ixAPI','ixHMP'], refId:446, descriptions:{
						default_en:"The student chooses an appropriate format for the product that reflects what was learned. Students' interests, strengths & prior experiences may influence these choices. Teachers may need to provide assistance in the selection & development of the product.",
						kids_en:"The student chooses an appropriate format for the product that reflects what was learned. Students' interests, strengths & prior experiences may influence these choices. Teachers may need to provide assistance in the selection & development of the product."
					}
		},				
		transProd:{
			id:"transProd",title:"Transformations", type: "product", indicators:['ixSH','ixEIC','ixTM','ixGC','ixRTW','ixLE'], refId:448, descriptions:{
						default_en:"The results of the learning process should represent a \"conversion of known information into new entities - changes in meaning, significance, use, interpretation, mood, sensory qualities,or shape\" (Guilford, 1967).",
						kids_en:"The results of the learning process should represent a \"conversion of known information into new entities - changes in meaning, significance, use, interpretation, mood, sensory qualities,or shape\" (Guilford, 1967)."
					}
		},						
		prodVariety:{
			id:"prodVariety",title:"Variety", type: "product", indicators:['ixEIC','ixPIM','ixGC','ixSCP','ixIU','ixLE','ixAPI','ixHMP'], refId:450, descriptions:{
						default_en:"Students learn about & use different types of production techniques & media throughout the school year or term. They should also learn to select an appropriate format for the audience & content.",
						kids_en:"Students learn about & use different types of production techniques & media throughout the school year or term. They should also learn to select an appropriate format for the audience & content."
					}
		}
	}
};



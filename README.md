# firstRECON - Web Application for Reconnaissance

## Overview  
**firstRECON** is an essential web application designed for individuals interested in **network defense, security posture assessment**, or **educational purposes**. This application integrates **Ping, DNS Lookup**, and **advanced port scanning** features, allowing users to identify potential vulnerabilities and possible exploits of a targeted host.

Developing a web application necessitates significant time and effort. To integrate the required functionalities, extensive research was conducted on existing approaches. Additionally, a **Gantt chart** and a **work breakdown structure** were created to ensure timely completion of tasks.

Proper web application design was performed from scratch to ensure functionality. This included defining the **feature-wise flowchart, sequence diagram, and communication diagram**. Extensive research was carried out to identify the best methodologies, analyzing their advantages and disadvantages. Ultimately, the **Agile Extreme Programming** approach was adopted to ensure efficient development, accompanied by **comprehensive documentation**.

---

## 2.6 Requirement Analysis 

### 2.6.1 Overall Requirement  
As this project is fully based on a web platform, loading or accessing the web application doesn’t require any specialized hardware. Every modern web browser is capable of rendering this application.  
Some requirements for running this web application are listed below:  

- **Smartphone or laptop**  
- **Stable internet connection**  
- **Web browser**: Google Chrome, Safari, Firefox, etc.  

### 2.6.2 Generalized List of Requirements  

#### 2.6.2.1 Functional Requirements  
- Users can log in to the web application.  
- Users can register a new account.  
- Users can view the features of the web application without logging in.  
- Users can understand the function of the program without logging in through the description provided on the homepage.  

#### 2.6.2.2 Non-functional Requirements  
- Users can get detailed information about **Port Scan** results.  
- Users can get the **DNS record** information of the targeted host.  
- Users can check the **ping status** of any targeted host.  

#### 2.6.2.3 Usability Requirements  
- Users can switch between different pages by clicking the program logo.  
- Users can log out by clicking their name displayed after login.  
- Users can select the type of **DNS record** while performing a **DNS Lookup**.  
- Users can choose the type of **port scan** while performing a **Port Scan** (i.e., **Package, Range, Custom scan**).  

### 2.6.3 Platform Used in This Project  
- **IDE**: PhpStorm  
- **DevOps Tool**: Docker  
- **Database**: MySQL  
- **APIs**:  
  - NVD API (National Vulnerability Database)  
  - SerpApi API  
- **Frontend**: HTML, CSS, JavaScript  
- **Backend Framework**: Laravel / PHP  
- **Documentation**: Microsoft Word  
- **Gantt Chart**: ClickUp  
- **Survey**: Google Forms  
- **Diagram Tool**: draw.io  
- **Other Tools**: Nmap, Windows Command Line  

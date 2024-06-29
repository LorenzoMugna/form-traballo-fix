import {useState, Fragment} from 'react';
import { TextField, Button, Stack, FormLabel, RadioGroup, FormControlLabel, Radio, Typography, FormControlLabelProps, Checkbox, FormGroup } from '@mui/material';
import { MuiFileInput } from 'mui-file-input';
import SendIcon from '@mui/icons-material/Send';
import CloseIcon from "@mui/icons-material/Close";
import styled from '@emotion/styled';
import axios from "axios";

const StyledFormControlLabel = styled((props:FormControlLabelProps) => (
  <FormControlLabel {...props} />
))(() => ({
  ".MuiFormControlLabel-asterisk": {
    display: "none"
  }
}));

const RadioGroupOther = (props:any) => {
  return (
    <Fragment>
      <FormLabel id={props.title} required>{props.title}</FormLabel>
      <RadioGroup
        aria-labelledby={props.title}
        value={props.state}
        onChange={e => props.setState(e.target.value)}
        sx={{mb:4}}
      >
        {props.choices.map((choice:any) => {
          return <StyledFormControlLabel value={choice} control={<Radio required/>} label={choice} />
        })}
        <StyledFormControlLabel value="Other" control={<Radio required/>} label="Other" />
      {(props.state === "Other") && <TextField
          type="text"
          variant='outlined'
          color='secondary'
          label="If other, please specify"
          onChange={e => props.setOtherState(e.target.value)}
          value={props.otherState}
          required={props.state === "Other"}
      />}
      </RadioGroup>
    </Fragment>
  )
}

const RegisterForm = (props:{submitSuccess:() => void, submitFailure:() => void}) => {
  const [firstName, setFirstName] = useState('')
  const [lastName, setLastName] = useState('')
  const [email, setEmail] = useState('')
  const [university, setUniversity] = useState('')

  const [fos, setFos] = useState('')
  const [otherFos, setOtherFos] = useState('')

  const [attendance, setAttendance] = useState('')
  const [otherAttendance, setOtherAttendance] = useState('')

  const [motivation, setMotivation] = useState('')
  
  const [cv, setCv] = useState<File | null>(null)

  const [allowImages, setAllowImages] = useState(false)

  const handleCvChange = (val:File | null) => {
    console.log(val)
    setCv(val)
  }

  async function handleSubmit(event:any) {
      event.preventDefault();
      const data = {
        firstName, lastName, email, university, fos: (fos === "Other") ? otherFos : fos, attendance: (attendance === "Other") ? otherAttendance : attendance, motivation, cv:cv!, allowImages
      }
      console.log(data)
      try {
        await axios.postForm("../submit.php", data)
        props.submitSuccess()
      } catch(e:any) {
        console.error(e)
        props.submitFailure()
      }
  }

  //action={<Link to="/login" />}>
  return (
    <Fragment>
      <Typography align="center" color="secondary" variant="h4" sx={{mt:4,mb:2}}>Apply for our Business Game</Typography>
      <Typography sx={{mb:4}}>Welcome, we are pleased to meet you and look forward to welcoming you here in Pisa! Please fill the form below with all your personal details and you will be contacted within 72 hours regarding the selection process. </Typography>

      <form onSubmit={handleSubmit}>
        <Stack spacing={2} direction="row" sx={{marginBottom: 4}}>
          <TextField
              type="text"
              variant='outlined'
              color='secondary'
              label="First Name"
              onChange={e => setFirstName(e.target.value)}
              value={firstName}
              fullWidth
              required
          />
          <TextField
              type="text"
              variant='outlined'
              color='secondary'
              label="Last Name"
              onChange={e => setLastName(e.target.value)}
              value={lastName}
              fullWidth
              required
          />
        </Stack>
        <TextField
            type="email"
            variant='outlined'
            color='secondary'
            label="Email"
            onChange={e => setEmail(e.target.value)}
            value={email}
            fullWidth
            required
            sx={{mb: 4}}
        />
        <TextField
            type="text"
            variant='outlined'
            color='secondary'
            label="University"
            onChange={e => setUniversity(e.target.value)}
            value={university}
            required
            fullWidth
            sx={{mb: 4}}
        />

        <RadioGroupOther title="Field of study" state={fos} setState={setFos} otherState={otherFos} setOtherState={setOtherFos} choices={
          ["Economics", "Business Administration and Management", "Business and Finance", "Computer Science / IT", "Management and commercial engineering", "Civil/Industrial engineering", "Aeronautical engineering", "Mechanical engineering", "Electronical engineering", "Political sciences / International Relations"]
        }/>
        <RadioGroupOther title="Current year of attendance" state={attendance} setState={setAttendance} otherState={otherAttendance} setOtherState={setOtherAttendance} choices={
          ["First year of Bachelor Degree", "Second year of Bachelor Degree", "Third year of Bachelor Degree", "First year of Master's Degree", "Second year of Master's Degree"]
        }/>

        <TextField
            type="text"
            variant='outlined'
            multiline={true}
            minRows={3}
            color='secondary'
            label="In a few words, tell us why you decided to apply for our Business Game"
            onChange={e => setMotivation(e.target.value)}
            value={motivation}
            required
            fullWidth
            sx={{mb: 4}}
        />

        <MuiFileInput
          label="Please attach your CV here"
          required
          value={cv}
          onChange={handleCvChange}
          fullWidth
          sx={{mb:4}}
          clearIconButtonProps={{
            title: "Remove",
            children: <CloseIcon fontSize="small" />
          }}
        />
        <Typography sx={{mb:4}}>
        In accordance with Legislative Decree no. 196 of 2003 on privacy and with Royal Decree no. 633 of 1941 on the right to the image I authorise
        </Typography>
        <FormGroup><FormControlLabel control={<Checkbox checked={allowImages} onChange={(event) => setAllowImages(event.target.checked)}/>} sx={{mb:4}} label="free of charge, without any time limit, also pursuant to Articles 10 and 320 of the Italian Civil Code and Articles 96 and 97 of Law no. 633 of 22 April 1941 (Copyright Law), to the publication and/or dissemination in any form of its images on the website and/or official social networks (Instagram, LinkedIn) of the unrecognised Junior Enterprise Business Engineering Association, as well as authorises the storage of the photos and videos in the Association's computer archives and acknowledges that the purpose of such publications is purely informative and possibly promotional;"/></FormGroup>
        <FormGroup><FormControlLabel required control={<Checkbox />} sx={{mb:4}} label="to the transfer, without time limits, of the personal data contained in the curricula vitae, sent by the participants, for the recruitment procedures of the event sponsors, who will undertake to process them in full compliance with the provisions of Regulation (EU) 679/2016 and Legislative Decree no. 196 of 30 June 2003." /></FormGroup>

        <Typography align="center"><Button variant="outlined" color="primary" type="submit" endIcon={<SendIcon/>}>Apply</Button></Typography>
      </form>
    </Fragment>
  )
}
 
export default RegisterForm;
